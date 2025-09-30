<?php
/**
 * NativeMind Marketplace Product Management Interface
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Api;

use NativeMind\Marketplace\Api\Data\ProductInterface;

/**
 * Interface ProductManagementInterface
 * @package NativeMind\Marketplace\Api
 */
interface ProductManagementInterface
{
    /**
     * Add product to seller's catalog
     *
     * @param int $sellerId
     * @param int $productId
     * @param string $condition
     * @return ProductInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function addProduct(int $sellerId, int $productId, string $condition = 'new'): ProductInterface;

    /**
     * Remove product from seller's catalog
     *
     * @param int $sellerId
     * @param int $productId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function removeProduct(int $sellerId, int $productId): bool;

    /**
     * Approve product
     *
     * @param int $productId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function approveProduct(int $productId): bool;

    /**
     * Reject product
     *
     * @param int $productId
     * @param string $reason
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function rejectProduct(int $productId, string $reason = ''): bool;

    /**
     * Update product condition
     *
     * @param int $sellerId
     * @param int $productId
     * @param string $condition
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateProductCondition(int $sellerId, int $productId, string $condition): bool;

    /**
     * Check if seller can add product
     *
     * @param int $sellerId
     * @return bool
     */
    public function canAddProduct(int $sellerId): bool;

    /**
     * Get seller's product count
     *
     * @param int $sellerId
     * @return int
     */
    public function getSellerProductCount(int $sellerId): int;

    /**
     * Get seller's approved product count
     *
     * @param int $sellerId
     * @return int
     */
    public function getSellerApprovedProductCount(int $sellerId): int;

    /**
     * Get seller's pending product count
     *
     * @param int $sellerId
     * @return int
     */
    public function getSellerPendingProductCount(int $sellerId): int;

    /**
     * Get seller's product statistics
     *
     * @param int $sellerId
     * @return array
     */
    public function getSellerProductStatistics(int $sellerId): array;

    /**
     * Bulk approve products
     *
     * @param array $productIds
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function bulkApproveProducts(array $productIds): bool;

    /**
     * Bulk reject products
     *
     * @param array $productIds
     * @param string $reason
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function bulkRejectProducts(array $productIds, string $reason = ''): bool;

    /**
     * Get products by condition
     *
     * @param string $condition
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getProductsByCondition(string $condition, int $limit = 10, int $offset = 0): array;

    /**
     * Get seller's products by condition
     *
     * @param int $sellerId
     * @param string $condition
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getSellerProductsByCondition(int $sellerId, string $condition, int $limit = 10, int $offset = 0): array;

    /**
     * Validate product condition
     *
     * @param string $condition
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function validateProductCondition(string $condition): bool;

    /**
     * Get available product conditions
     *
     * @return array
     */
    public function getAvailableProductConditions(): array;

    /**
     * Check if product exists for seller
     *
     * @param int $sellerId
     * @param int $productId
     * @return bool
     */
    public function productExistsForSeller(int $sellerId, int $productId): bool;

    /**
     * Get product approval status
     *
     * @param int $sellerId
     * @param int $productId
     * @return string
     */
    public function getProductApprovalStatus(int $sellerId, int $productId): string;
}

