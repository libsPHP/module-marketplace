<?php
/**
 * NativeMind Marketplace Review Management Interface
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Api;

use NativeMind\Marketplace\Api\Data\ReviewInterface;

/**
 * Interface ReviewManagementInterface
 * @package NativeMind\Marketplace\Api
 */
interface ReviewManagementInterface
{
    /**
     * Create review
     *
     * @param array $reviewData
     * @return ReviewInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createReview(array $reviewData): ReviewInterface;

    /**
     * Approve review
     *
     * @param int $reviewId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function approveReview(int $reviewId): bool;

    /**
     * Reject review
     *
     * @param int $reviewId
     * @param string $reason
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function rejectReview(int $reviewId, string $reason = ''): bool;

    /**
     * Update review
     *
     * @param int $reviewId
     * @param array $reviewData
     * @return ReviewInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateReview(int $reviewId, array $reviewData): ReviewInterface;

    /**
     * Delete review
     *
     * @param int $reviewId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteReview(int $reviewId): bool;

    /**
     * Check if customer can review seller
     *
     * @param int $customerId
     * @param int $sellerId
     * @return bool
     */
    public function canCustomerReviewSeller(int $customerId, int $sellerId): bool;

    /**
     * Check if customer has reviewed seller
     *
     * @param int $customerId
     * @param int $sellerId
     * @return bool
     */
    public function hasCustomerReviewedSeller(int $customerId, int $sellerId): bool;

    /**
     * Get seller average rating
     *
     * @param int $sellerId
     * @return float
     */
    public function getSellerAverageRating(int $sellerId): float;

    /**
     * Get seller review count
     *
     * @param int $sellerId
     * @return int
     */
    public function getSellerReviewCount(int $sellerId): int;

    /**
     * Get seller rating distribution
     *
     * @param int $sellerId
     * @return array
     */
    public function getSellerRatingDistribution(int $sellerId): array;

    /**
     * Get seller reviews summary
     *
     * @param int $sellerId
     * @return array
     */
    public function getSellerReviewsSummary(int $sellerId): array;

    /**
     * Bulk approve reviews
     *
     * @param array $reviewIds
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function bulkApproveReviews(array $reviewIds): bool;

    /**
     * Bulk reject reviews
     *
     * @param array $reviewIds
     * @param string $reason
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function bulkRejectReviews(array $reviewIds, string $reason = ''): bool;

    /**
     * Validate review data
     *
     * @param array $reviewData
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function validateReviewData(array $reviewData): bool;

    /**
     * Get review statistics
     *
     * @param int $sellerId
     * @return array
     */
    public function getReviewStatistics(int $sellerId): array;

    /**
     * Update seller rating after review change
     *
     * @param int $sellerId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateSellerRating(int $sellerId): bool;
}

