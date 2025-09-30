<?php
/**
 * NativeMind Marketplace Seller Management Interface
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Api;

use NativeMind\Marketplace\Api\Data\SellerInterface;

/**
 * Interface SellerManagementInterface
 * @package NativeMind\Marketplace\Api
 */
interface SellerManagementInterface
{
    /**
     * Register new seller
     *
     * @param array $sellerData
     * @return SellerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function register(array $sellerData): SellerInterface;

    /**
     * Approve seller
     *
     * @param int $sellerId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function approve(int $sellerId): bool;

    /**
     * Suspend seller
     *
     * @param int $sellerId
     * @param string $reason
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function suspend(int $sellerId, string $reason = ''): bool;

    /**
     * Reject seller
     *
     * @param int $sellerId
     * @param string $reason
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function reject(int $sellerId, string $reason = ''): bool;

    /**
     * Activate seller
     *
     * @param int $sellerId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function activate(int $sellerId): bool;

    /**
     * Deactivate seller
     *
     * @param int $sellerId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deactivate(int $sellerId): bool;

    /**
     * Update seller rating
     *
     * @param int $sellerId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateRating(int $sellerId): bool;

    /**
     * Update seller statistics
     *
     * @param int $sellerId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateStatistics(int $sellerId): bool;

    /**
     * Check if seller can register
     *
     * @param int $customerId
     * @return bool
     */
    public function canRegister(int $customerId): bool;

    /**
     * Validate seller data
     *
     * @param array $sellerData
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function validateSellerData(array $sellerData): bool;

    /**
     * Generate unique subdomain
     *
     * @param string $companyName
     * @return string
     */
    public function generateSubdomain(string $companyName): string;

    /**
     * Check subdomain availability
     *
     * @param string $subdomain
     * @return bool
     */
    public function isSubdomainAvailable(string $subdomain): bool;

    /**
     * Get seller dashboard data
     *
     * @param int $sellerId
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getDashboardData(int $sellerId): array;

    /**
     * Send seller notification
     *
     * @param int $sellerId
     * @param string $type
     * @param array $data
     * @return bool
     */
    public function sendNotification(int $sellerId, string $type, array $data = []): bool;
}

