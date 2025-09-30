<?php
/**
 * NativeMind Marketplace Review Model
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Model;

use Magento\Framework\Model\AbstractModel;
use NativeMind\Marketplace\Api\Data\ReviewInterface;

/**
 * Class Review
 * @package NativeMind\Marketplace\Model
 */
class Review extends AbstractModel implements ReviewInterface
{
    /**
     * Approval status constants
     */
    const NOT_APPROVED = 0;
    const APPROVED = 1;

    /**
     * Rating constants
     */
    const MIN_RATING = 1;
    const MAX_RATING = 5;

    /**
     * @var string
     */
    protected $_eventPrefix = 'native_marketplace_review';

    /**
     * @var string
     */
    protected $_eventObject = 'review';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\NativeMind\Marketplace\Model\ResourceModel\Review::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getReviewId(): ?int
    {
        return $this->getData(self::REVIEW_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setReviewId(int $reviewId): ReviewInterface
    {
        return $this->setData(self::REVIEW_ID, $reviewId);
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerId(): ?int
    {
        return $this->getData(self::SELLER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setSellerId(int $sellerId): ReviewInterface
    {
        return $this->setData(self::SELLER_ID, $sellerId);
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerId(): ?int
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomerId(int $customerId): ReviewInterface
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderId(): ?int
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setOrderId(int $orderId): ReviewInterface
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * {@inheritdoc}
     */
    public function getRating(): ?int
    {
        return $this->getData(self::RATING);
    }

    /**
     * {@inheritdoc}
     */
    public function setRating(int $rating): ReviewInterface
    {
        return $this->setData(self::RATING, $rating);
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): ?string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle(string $title): ReviewInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * {@inheritdoc}
     */
    public function getComment(): ?string
    {
        return $this->getData(self::COMMENT);
    }

    /**
     * {@inheritdoc}
     */
    public function setComment(string $comment): ReviewInterface
    {
        return $this->setData(self::COMMENT, $comment);
    }

    /**
     * {@inheritdoc}
     */
    public function getIsApproved(): ?int
    {
        return $this->getData(self::IS_APPROVED);
    }

    /**
     * {@inheritdoc}
     */
    public function setIsApproved(int $isApproved): ReviewInterface
    {
        return $this->setData(self::IS_APPROVED, $isApproved);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(string $createdAt): ReviewInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(string $updatedAt): ReviewInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Check if review is approved
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->getIsApproved() == self::APPROVED;
    }

    /**
     * Check if review is pending
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->getIsApproved() == self::NOT_APPROVED;
    }

    /**
     * Get approval status label
     *
     * @return string
     */
    public function getApprovalStatusLabel(): string
    {
        return $this->isApproved() ? __('Approved') : __('Pending');
    }

    /**
     * Get rating stars
     *
     * @return string
     */
    public function getRatingStars(): string
    {
        $rating = $this->getRating();
        $stars = '';
        
        for ($i = 1; $i <= self::MAX_RATING; $i++) {
            if ($i <= $rating) {
                $stars .= '<span class="star filled">★</span>';
            } else {
                $stars .= '<span class="star empty">☆</span>';
            }
        }
        
        return $stars;
    }

    /**
     * Validate rating
     *
     * @param int $rating
     * @return bool
     */
    public function validateRating(int $rating): bool
    {
        return $rating >= self::MIN_RATING && $rating <= self::MAX_RATING;
    }

    /**
     * Get available ratings
     *
     * @return array
     */
    public static function getAvailableRatings(): array
    {
        return [
            self::MIN_RATING => __('1 Star'),
            2 => __('2 Stars'),
            3 => __('3 Stars'),
            4 => __('4 Stars'),
            self::MAX_RATING => __('5 Stars')
        ];
    }
}

