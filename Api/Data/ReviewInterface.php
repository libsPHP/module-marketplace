<?php
/**
 * NativeMind Marketplace Review Data Interface
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Api\Data;

/**
 * Interface ReviewInterface
 * @package NativeMind\Marketplace\Api\Data
 */
interface ReviewInterface
{
    const REVIEW_ID = 'review_id';
    const SELLER_ID = 'seller_id';
    const CUSTOMER_ID = 'customer_id';
    const ORDER_ID = 'order_id';
    const RATING = 'rating';
    const TITLE = 'title';
    const COMMENT = 'comment';
    const IS_APPROVED = 'is_approved';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Get review ID
     *
     * @return int|null
     */
    public function getReviewId(): ?int;

    /**
     * Set review ID
     *
     * @param int $reviewId
     * @return ReviewInterface
     */
    public function setReviewId(int $reviewId): ReviewInterface;

    /**
     * Get seller ID
     *
     * @return int|null
     */
    public function getSellerId(): ?int;

    /**
     * Set seller ID
     *
     * @param int $sellerId
     * @return ReviewInterface
     */
    public function setSellerId(int $sellerId): ReviewInterface;

    /**
     * Get customer ID
     *
     * @return int|null
     */
    public function getCustomerId(): ?int;

    /**
     * Set customer ID
     *
     * @param int $customerId
     * @return ReviewInterface
     */
    public function setCustomerId(int $customerId): ReviewInterface;

    /**
     * Get order ID
     *
     * @return int|null
     */
    public function getOrderId(): ?int;

    /**
     * Set order ID
     *
     * @param int $orderId
     * @return ReviewInterface
     */
    public function setOrderId(int $orderId): ReviewInterface;

    /**
     * Get rating
     *
     * @return int|null
     */
    public function getRating(): ?int;

    /**
     * Set rating
     *
     * @param int $rating
     * @return ReviewInterface
     */
    public function setRating(int $rating): ReviewInterface;

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * Set title
     *
     * @param string $title
     * @return ReviewInterface
     */
    public function setTitle(string $title): ReviewInterface;

    /**
     * Get comment
     *
     * @return string|null
     */
    public function getComment(): ?string;

    /**
     * Set comment
     *
     * @param string $comment
     * @return ReviewInterface
     */
    public function setComment(string $comment): ReviewInterface;

    /**
     * Get is approved
     *
     * @return int|null
     */
    public function getIsApproved(): ?int;

    /**
     * Set is approved
     *
     * @param int $isApproved
     * @return ReviewInterface
     */
    public function setIsApproved(int $isApproved): ReviewInterface;

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Set created at
     *
     * @param string $createdAt
     * @return ReviewInterface
     */
    public function setCreatedAt(string $createdAt): ReviewInterface;

    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Set updated at
     *
     * @param string $updatedAt
     * @return ReviewInterface
     */
    public function setUpdatedAt(string $updatedAt): ReviewInterface;
}
