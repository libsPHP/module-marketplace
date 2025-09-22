<?php
/**
 * NativeMind Marketplace Seller Repository
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use NativeMind\Marketplace\Api\Data\SellerInterface;
use NativeMind\Marketplace\Api\SellerRepositoryInterface;
use NativeMind\Marketplace\Model\ResourceModel\Seller as SellerResource;
use NativeMind\Marketplace\Model\ResourceModel\Seller\CollectionFactory;

/**
 * Class SellerRepository
 * @package NativeMind\Marketplace\Model
 */
class SellerRepository implements SellerRepositoryInterface
{
    /**
     * @var SellerFactory
     */
    protected $sellerFactory;

    /**
     * @var SellerResource
     */
    protected $sellerResource;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var SearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * Constructor
     *
     * @param SellerFactory $sellerFactory
     * @param SellerResource $sellerResource
     * @param CollectionFactory $collectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        SellerFactory $sellerFactory,
        SellerResource $sellerResource,
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
    ) {
        $this->sellerFactory = $sellerFactory;
        $this->sellerResource = $sellerResource;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function save(SellerInterface $seller): SellerInterface
    {
        try {
            $this->sellerResource->save($seller);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save seller: %1', $exception->getMessage()),
                $exception
            );
        }
        return $seller;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $sellerId): SellerInterface
    {
        $seller = $this->sellerFactory->create();
        $this->sellerResource->load($seller, $sellerId);
        if (!$seller->getSellerId()) {
            throw new NoSuchEntityException(__('Seller with id "%1" does not exist.', $sellerId));
        }
        return $seller;
    }

    /**
     * {@inheritdoc}
     */
    public function getByCustomerId(int $customerId): SellerInterface
    {
        $seller = $this->sellerFactory->create();
        $this->sellerResource->loadByCustomerId($seller, $customerId);
        if (!$seller->getSellerId()) {
            throw new NoSuchEntityException(__('Seller with customer id "%1" does not exist.', $customerId));
        }
        return $seller;
    }

    /**
     * {@inheritdoc}
     */
    public function getBySubdomain(string $subdomain): SellerInterface
    {
        $seller = $this->sellerFactory->create();
        $this->sellerResource->loadBySubdomain($seller, $subdomain);
        if (!$seller->getSellerId()) {
            throw new NoSuchEntityException(__('Seller with subdomain "%1" does not exist.', $subdomain));
        }
        return $seller;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(SellerInterface $seller): bool
    {
        try {
            $this->sellerResource->delete($seller);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete seller: %1', $exception->getMessage()),
                $exception
            );
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById(int $sellerId): bool
    {
        return $this->delete($this->getById($sellerId));
    }

    /**
     * {@inheritdoc}
     */
    public function exists(int $sellerId): bool
    {
        try {
            $this->getById($sellerId);
            return true;
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getApprovedSellers(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('status', Seller::STATUS_ACTIVE);
        $collection->addFieldToFilter('approval_status', Seller::APPROVAL_STATUS_APPROVED);
        
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function getPendingSellers(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('approval_status', Seller::APPROVAL_STATUS_PENDING);
        
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
