<?php
/**
 * NativeMind Marketplace Product Management
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Model;

use Magento\Framework\Exception\LocalizedException;
use NativeMind\Marketplace\Api\Data\ProductInterface;
use NativeMind\Marketplace\Api\ProductManagementInterface;
use NativeMind\Marketplace\Api\ProductRepositoryInterface;
use NativeMind\Marketplace\Api\SellerRepositoryInterface;
use NativeMind\Marketplace\Helper\Data as MarketplaceHelper;

/**
 * Class ProductManagement
 * @package NativeMind\Marketplace\Model
 */
class ProductManagement implements ProductManagementInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var SellerRepositoryInterface
     */
    protected $sellerRepository;

    /**
     * @var MarketplaceHelper
     */
    protected $marketplaceHelper;

    /**
     * Constructor
     *
     * @param ProductRepositoryInterface $productRepository
     * @param SellerRepositoryInterface $sellerRepository
     * @param MarketplaceHelper $marketplaceHelper
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        SellerRepositoryInterface $sellerRepository,
        MarketplaceHelper $marketplaceHelper
    ) {
        $this->productRepository = $productRepository;
        $this->sellerRepository = $sellerRepository;
        $this->marketplaceHelper = $marketplaceHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function addProduct(int $sellerId, int $productId, string $condition = 'new'): ProductInterface
    {
        if (!$this->marketplaceHelper->isEnabled()) {
            throw new LocalizedException(__('Marketplace is not enabled.'));
        }

        if (!$this->canAddProduct($sellerId)) {
            throw new LocalizedException(__('Seller cannot add more products.'));
        }

        if ($this->productExistsForSeller($sellerId, $productId)) {
            throw new LocalizedException(__('Product already exists for this seller.'));
        }

        $this->validateProductCondition($condition);

        $seller = $this->sellerRepository->getById($sellerId);
        if (!$seller->isActive() || !$seller->isApproved()) {
            throw new LocalizedException(__('Seller is not active or approved.'));
        }

        $product = $this->productRepository->getById(0); // Create new product
        $product->setSellerId($sellerId);
        $product->setProductId($productId);
        $product->setCondition($condition);
        $product->setIsApproved($this->marketplaceHelper->isAutoApproveProductsEnabled() ? 
            Product::APPROVED : Product::NOT_APPROVED);

        $this->productRepository->save($product);

        return $product;
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(int $sellerId, int $productId): bool
    {
        $product = $this->productRepository->getBySellerAndProduct($sellerId, $productId);
        $this->productRepository->delete($product);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function approveProduct(int $productId): bool
    {
        $product = $this->productRepository->getById($productId);
        $product->setIsApproved(Product::APPROVED);
        $this->productRepository->save($product);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rejectProduct(int $productId, string $reason = ''): bool
    {
        $product = $this->productRepository->getById($productId);
        $product->setIsApproved(Product::NOT_APPROVED);
        $this->productRepository->save($product);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function updateProductCondition(int $sellerId, int $productId, string $condition): bool
    {
        $this->validateProductCondition($condition);

        $product = $this->productRepository->getBySellerAndProduct($sellerId, $productId);
        $product->setCondition($condition);
        $this->productRepository->save($product);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function canAddProduct(int $sellerId): bool
    {
        $maxProducts = $this->marketplaceHelper->getMaxProductsPerSeller();
        $currentCount = $this->getSellerProductCount($sellerId);

        return $currentCount < $maxProducts;
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerProductCount(int $sellerId): int
    {
        $seller = $this->sellerRepository->getById($sellerId);
        return $seller->getProductCount();
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerApprovedProductCount(int $sellerId): int
    {
        // This would need to be implemented with a proper query
        // For now, return a placeholder
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerPendingProductCount(int $sellerId): int
    {
        // This would need to be implemented with a proper query
        // For now, return a placeholder
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerProductStatistics(int $sellerId): array
    {
        $seller = $this->sellerRepository->getById($sellerId);
        
        return [
            'total_products' => $seller->getProductCount(),
            'approved_products' => $this->getSellerApprovedProductCount($sellerId),
            'pending_products' => $this->getSellerPendingProductCount($sellerId),
            'can_add_more' => $this->canAddProduct($sellerId),
            'max_products' => $this->marketplaceHelper->getMaxProductsPerSeller()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function bulkApproveProducts(array $productIds): bool
    {
        foreach ($productIds as $productId) {
            $this->approveProduct($productId);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function bulkRejectProducts(array $productIds, string $reason = ''): bool
    {
        foreach ($productIds as $productId) {
            $this->rejectProduct($productId, $reason);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getProductsByCondition(string $condition, int $limit = 10, int $offset = 0): array
    {
        $this->validateProductCondition($condition);
        
        // This would need to be implemented with a proper query
        // For now, return empty array
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerProductsByCondition(int $sellerId, string $condition, int $limit = 10, int $offset = 0): array
    {
        $this->validateProductCondition($condition);
        
        // This would need to be implemented with a proper query
        // For now, return empty array
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function validateProductCondition(string $condition): bool
    {
        $availableConditions = $this->getAvailableProductConditions();
        
        if (!isset($availableConditions[$condition])) {
            throw new LocalizedException(__('Invalid product condition: %1', $condition));
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableProductConditions(): array
    {
        return Product::getAvailableConditions();
    }

    /**
     * {@inheritdoc}
     */
    public function productExistsForSeller(int $sellerId, int $productId): bool
    {
        try {
            $this->productRepository->getBySellerAndProduct($sellerId, $productId);
            return true;
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductApprovalStatus(int $sellerId, int $productId): string
    {
        try {
            $product = $this->productRepository->getBySellerAndProduct($sellerId, $productId);
            return $product->getApprovalStatusLabel();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return __('Not Found');
        }
    }
}

