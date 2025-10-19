<?php
/**
 * Copyright © NativeMind. All rights reserved.
 */
declare(strict_types=1);

namespace NativeMind\Marketplace\Api;

/**
 * Admin management interface
 */
interface AdminManagementInterface
{
    /**
     * Get marketplace statistics
     *
     * @return \NativeMind\Marketplace\Api\Data\StatsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getStats(): \NativeMind\Marketplace\Api\Data\StatsInterface;

    /**
     * Get pending sellers
     *
     * @param int $pageSize
     * @param int $currentPage
     * @return \NativeMind\Marketplace\Api\Data\SellerInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getPendingSellers(int $pageSize = 20, int $currentPage = 1): array;

    /**
     * Approve seller
     *
     * @param int $sellerId
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function approveSeller(int $sellerId): bool;

    /**
     * Reject seller
     *
     * @param int $sellerId
     * @param string $reason
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function rejectSeller(int $sellerId, string $reason): bool;

    /**
     * Bulk approve sellers
     *
     * @param int[] $sellerIds
     * @return array Array with 'success' and 'failed' keys
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function bulkApproveSellers(array $sellerIds): array;

    /**
     * Bulk reject sellers
     *
     * @param int[] $sellerIds
     * @param string $reason
     * @return array Array with 'success' and 'failed' keys
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function bulkRejectSellers(array $sellerIds, string $reason): array;

    /**
     * Get seller activity log
     *
     * @param int $sellerId
     * @param int $limit
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getSellerActivityLog(int $sellerId, int $limit = 50): array;

    /**
     * Update seller status
     *
     * @param int $sellerId
     * @param string $status
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateSellerStatus(int $sellerId, string $status): bool;

    /**
     * Get marketplace configuration
     *
     * @return array
     */
    public function getConfiguration(): array;

    /**
     * Update marketplace configuration
     *
     * @param array $config
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateConfiguration(array $config): bool;
}

