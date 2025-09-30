<?php
/**
 * NativeMind Marketplace Seller View Block
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Block\Seller;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use NativeMind\Marketplace\Api\Data\SellerInterface;
use NativeMind\Marketplace\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * Class View
 * @package NativeMind\Marketplace\Block\Seller
 */
class View extends Template
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Registry $registry
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);
    }

    /**
     * Get current seller
     *
     * @return SellerInterface|null
     */
    public function getCurrentSeller(): ?SellerInterface
    {
        return $this->registry->registry('current_seller');
    }

    /**
     * Get seller products
     *
     * @param int $limit
     * @return \NativeMind\Marketplace\Api\Data\ProductInterface[]
     */
    public function getSellerProducts(int $limit = 12): array
    {
        $seller = $this->getCurrentSeller();
        if (!$seller) {
            return [];
        }

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('seller_id', $seller->getSellerId())
            ->addFilter('is_approved', 1)
            ->setPageSize($limit)
            ->setCurrentPage(1)
            ->create();

        $searchResults = $this->productRepository->getBySeller($seller->getSellerId(), $searchCriteria);
        return $searchResults->getItems();
    }

    /**
     * Get seller rating
     *
     * @return float
     */
    public function getSellerRating(): float
    {
        $seller = $this->getCurrentSeller();
        return $seller ? $seller->getRating() : 0.0;
    }

    /**
     * Get seller review count
     *
     * @return int
     */
    public function getSellerReviewCount(): int
    {
        $seller = $this->getCurrentSeller();
        return $seller ? $seller->getReviewCount() : 0;
    }

    /**
     * Get seller product count
     *
     * @return int
     */
    public function getSellerProductCount(): int
    {
        $seller = $this->getCurrentSeller();
        return $seller ? $seller->getProductCount() : 0;
    }

    /**
     * Get seller company name
     *
     * @return string
     */
    public function getSellerCompanyName(): string
    {
        $seller = $this->getCurrentSeller();
        return $seller ? $seller->getCompanyName() : '';
    }

    /**
     * Get seller address
     *
     * @return string
     */
    public function getSellerAddress(): string
    {
        $seller = $this->getCurrentSeller();
        if (!$seller) {
            return '';
        }

        $addressParts = array_filter([
            $seller->getAddress(),
            $seller->getCity(),
            $seller->getRegion(),
            $seller->getPostcode()
        ]);

        return implode(', ', $addressParts);
    }

    /**
     * Get seller phone
     *
     * @return string
     */
    public function getSellerPhone(): string
    {
        $seller = $this->getCurrentSeller();
        return $seller ? $seller->getPhone() : '';
    }

    /**
     * Get seller subdomain
     *
     * @return string
     */
    public function getSellerSubdomain(): string
    {
        $seller = $this->getCurrentSeller();
        return $seller ? $seller->getSubdomain() : '';
    }

    /**
     * Get seller store URL
     *
     * @return string
     */
    public function getSellerStoreUrl(): string
    {
        $subdomain = $this->getSellerSubdomain();
        if (!$subdomain) {
            return '';
        }

        return $this->_urlBuilder->getUrl('marketplace/seller/view', ['subdomain' => $subdomain]);
    }

    /**
     * Get seller products URL
     *
     * @return string
     */
    public function getSellerProductsUrl(): string
    {
        $subdomain = $this->getSellerSubdomain();
        if (!$subdomain) {
            return '';
        }

        return $this->_urlBuilder->getUrl('marketplace/seller/products', ['subdomain' => $subdomain]);
    }

    /**
     * Get seller reviews URL
     *
     * @return string
     */
    public function getSellerReviewsUrl(): string
    {
        $subdomain = $this->getSellerSubdomain();
        if (!$subdomain) {
            return '';
        }

        return $this->_urlBuilder->getUrl('marketplace/seller/reviews', ['subdomain' => $subdomain]);
    }

    /**
     * Get seller contact URL
     *
     * @return string
     */
    public function getSellerContactUrl(): string
    {
        $subdomain = $this->getSellerSubdomain();
        if (!$subdomain) {
            return '';
        }

        return $this->_urlBuilder->getUrl('marketplace/seller/contact', ['subdomain' => $subdomain]);
    }

    /**
     * Check if seller has products
     *
     * @return bool
     */
    public function hasProducts(): bool
    {
        return $this->getSellerProductCount() > 0;
    }

    /**
     * Check if seller has reviews
     *
     * @return bool
     */
    public function hasReviews(): bool
    {
        return $this->getSellerReviewCount() > 0;
    }

    /**
     * Get seller rating stars
     *
     * @return string
     */
    public function getSellerRatingStars(): string
    {
        $rating = $this->getSellerRating();
        $stars = '';
        
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '<span class="star filled">★</span>';
            } elseif ($i - 0.5 <= $rating) {
                $stars .= '<span class="star half">☆</span>';
            } else {
                $stars .= '<span class="star empty">☆</span>';
            }
        }
        
        return $stars;
    }

    /**
     * Get seller statistics
     *
     * @return array
     */
    public function getSellerStatistics(): array
    {
        $seller = $this->getCurrentSeller();
        if (!$seller) {
            return [];
        }

        return [
            'rating' => $seller->getRating(),
            'review_count' => $seller->getReviewCount(),
            'product_count' => $seller->getProductCount(),
            'total_sales' => $seller->getTotalSales(),
            'created_at' => $seller->getCreatedAt()
        ];
    }
}

