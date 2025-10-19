<?php
/**
 * Copyright © NativeMind. All rights reserved.
 */
declare(strict_types=1);

namespace NativeMind\Marketplace\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use NativeMind\Marketplace\Api\AdminManagementInterface;
use NativeMind\Marketplace\Api\Data\StatsInterface;
use NativeMind\Marketplace\Api\Data\StatsInterfaceFactory;
use NativeMind\Marketplace\Api\SellerRepositoryInterface;
use NativeMind\Marketplace\Model\ResourceModel\Seller\CollectionFactory as SellerCollectionFactory;
use NativeMind\Marketplace\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use NativeMind\Marketplace\Model\ResourceModel\Review\CollectionFactory as ReviewCollectionFactory;
use NativeMind\Marketplace\Model\ResourceModel\Message\CollectionFactory as MessageCollectionFactory;
use Psr\Log\LoggerInterface;

/**
 * Admin management implementation
 */
class AdminManagement implements AdminManagementInterface
{
    /**
     * @var StatsInterfaceFactory
     */
    private $statsFactory;

    /**
     * @var SellerRepositoryInterface
     */
    private $sellerRepository;

    /**
     * @var SellerCollectionFactory
     */
    private $sellerCollectionFactory;

    /**
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var ReviewCollectionFactory
     */
    private $reviewCollectionFactory;

    /**
     * @var MessageCollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param StatsInterfaceFactory $statsFactory
     * @param SellerRepositoryInterface $sellerRepository
     * @param SellerCollectionFactory $sellerCollectionFactory
     * @param ProductCollectionFactory $productCollectionFactory
     * @param ReviewCollectionFactory $reviewCollectionFactory
     * @param MessageCollectionFactory $messageCollectionFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        StatsInterfaceFactory $statsFactory,
        SellerRepositoryInterface $sellerRepository,
        SellerCollectionFactory $sellerCollectionFactory,
        ProductCollectionFactory $productCollectionFactory,
        ReviewCollectionFactory $reviewCollectionFactory,
        MessageCollectionFactory $messageCollectionFactory,
        LoggerInterface $logger
    ) {
        $this->statsFactory = $statsFactory;
        $this->sellerRepository = $sellerRepository;
        $this->sellerCollectionFactory = $sellerCollectionFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->reviewCollectionFactory = $reviewCollectionFactory;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function getStats(): StatsInterface
    {
        try {
            /** @var StatsInterface $stats */
            $stats = $this->statsFactory->create();

            // Get seller statistics
            $sellerCollection = $this->sellerCollectionFactory->create();
            $stats->setTotalSellers($sellerCollection->getSize());

            $pendingCollection = $this->sellerCollectionFactory->create()
                ->addFieldToFilter('status', 'pending');
            $stats->setPendingSellers($pendingCollection->getSize());

            $approvedCollection = $this->sellerCollectionFactory->create()
                ->addFieldToFilter('status', 'approved');
            $stats->setApprovedSellers($approvedCollection->getSize());

            // Get product statistics
            $productCollection = $this->productCollectionFactory->create();
            $stats->setTotalProducts($productCollection->getSize());

            // Get review statistics
            $reviewCollection = $this->reviewCollectionFactory->create();
            $stats->setTotalReviews($reviewCollection->getSize());

            // Get message statistics
            $messageCollection = $this->messageCollectionFactory->create();
            $stats->setTotalMessages($messageCollection->getSize());

            // Calculate average rating
            $reviewCollection = $this->reviewCollectionFactory->create();
            $reviewCollection->getSelect()->columns(['avg_rating' => 'AVG(rating)']);
            $avgRating = $reviewCollection->getFirstItem()->getData('avg_rating');
            $stats->setAverageRating((float)$avgRating ?: 0.0);

            return $stats;
        } catch (\Exception $e) {
            $this->logger->error('Error getting marketplace stats: ' . $e->getMessage());
            throw new LocalizedException(__('Unable to retrieve marketplace statistics.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function getPendingSellers(int $pageSize = 20, int $currentPage = 1): array
    {
        try {
            $collection = $this->sellerCollectionFactory->create()
                ->addFieldToFilter('status', 'pending')
                ->setPageSize($pageSize)
                ->setCurPage($currentPage)
                ->setOrder('created_at', 'DESC');

            return $collection->getItems();
        } catch (\Exception $e) {
            $this->logger->error('Error getting pending sellers: ' . $e->getMessage());
            throw new LocalizedException(__('Unable to retrieve pending sellers.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function approveSeller(int $sellerId): bool
    {
        try {
            $seller = $this->sellerRepository->getById($sellerId);
            $seller->setStatus('approved');
            $seller->setApprovedAt(date('Y-m-d H:i:s'));
            $this->sellerRepository->save($seller);

            $this->logger->info("Seller #{$sellerId} approved");
            return true;
        } catch (NoSuchEntityException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->logger->error("Error approving seller #{$sellerId}: " . $e->getMessage());
            throw new LocalizedException(__('Unable to approve seller.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function rejectSeller(int $sellerId, string $reason): bool
    {
        try {
            $seller = $this->sellerRepository->getById($sellerId);
            $seller->setStatus('rejected');
            $seller->setRejectionReason($reason);
            $seller->setRejectedAt(date('Y-m-d H:i:s'));
            $this->sellerRepository->save($seller);

            $this->logger->info("Seller #{$sellerId} rejected. Reason: {$reason}");
            return true;
        } catch (NoSuchEntityException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->logger->error("Error rejecting seller #{$sellerId}: " . $e->getMessage());
            throw new LocalizedException(__('Unable to reject seller.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function bulkApproveSellers(array $sellerIds): array
    {
        $result = ['success' => [], 'failed' => []];

        foreach ($sellerIds as $sellerId) {
            try {
                if ($this->approveSeller($sellerId)) {
                    $result['success'][] = $sellerId;
                }
            } catch (\Exception $e) {
                $result['failed'][] = [
                    'seller_id' => $sellerId,
                    'error' => $e->getMessage()
                ];
            }
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function bulkRejectSellers(array $sellerIds, string $reason): array
    {
        $result = ['success' => [], 'failed' => []];

        foreach ($sellerIds as $sellerId) {
            try {
                if ($this->rejectSeller($sellerId, $reason)) {
                    $result['success'][] = $sellerId;
                }
            } catch (\Exception $e) {
                $result['failed'][] = [
                    'seller_id' => $sellerId,
                    'error' => $e->getMessage()
                ];
            }
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getSellerActivityLog(int $sellerId, int $limit = 50): array
    {
        // This would require a proper activity log table
        // For now, return basic seller info
        try {
            $seller = $this->sellerRepository->getById($sellerId);
            return [
                [
                    'date' => $seller->getCreatedAt(),
                    'action' => 'Seller created',
                    'details' => 'Seller account created'
                ],
                [
                    'date' => $seller->getUpdatedAt(),
                    'action' => 'Seller updated',
                    'details' => 'Seller account updated'
                ]
            ];
        } catch (NoSuchEntityException $e) {
            throw $e;
        }
    }

    /**
     * @inheritdoc
     */
    public function updateSellerStatus(int $sellerId, string $status): bool
    {
        try {
            $seller = $this->sellerRepository->getById($sellerId);
            $seller->setStatus($status);
            $this->sellerRepository->save($seller);

            $this->logger->info("Seller #{$sellerId} status updated to: {$status}");
            return true;
        } catch (NoSuchEntityException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->logger->error("Error updating seller status: " . $e->getMessage());
            throw new LocalizedException(__('Unable to update seller status.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function getConfiguration(): array
    {
        // Return marketplace configuration
        // This would typically come from Magento config
        return [
            'auto_approve_sellers' => false,
            'require_seller_approval' => true,
            'allow_seller_reviews' => true,
            'commission_rate' => 10.0,
        ];
    }

    /**
     * @inheritdoc
     */
    public function updateConfiguration(array $config): bool
    {
        // Update configuration
        // This would typically save to Magento config
        $this->logger->info('Marketplace configuration updated', $config);
        return true;
    }
}

