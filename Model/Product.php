<?php
/**
 * NativeMind Marketplace Product Model
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Model;

use Magento\Framework\Model\AbstractModel;
use NativeMind\Marketplace\Api\Data\ProductInterface;

/**
 * Class Product
 * @package NativeMind\Marketplace\Model
 */
class Product extends AbstractModel implements ProductInterface
{
    /**
     * Condition constants
     */
    const CONDITION_NEW = 'new';
    const CONDITION_USED = 'used';
    const CONDITION_REFURBISHED = 'refurbished';
    const CONDITION_FOR_PARTS = 'for_parts';

    /**
     * Approval status constants
     */
    const NOT_APPROVED = 0;
    const APPROVED = 1;

    /**
     * @var string
     */
    protected $_eventPrefix = 'native_marketplace_product';

    /**
     * @var string
     */
    protected $_eventObject = 'product';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\NativeMind\Marketplace\Model\ResourceModel\Product::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->getData(self::ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setId(int $id): ProductInterface
    {
        return $this->setData(self::ID, $id);
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
    public function setSellerId(int $sellerId): ProductInterface
    {
        return $this->setData(self::SELLER_ID, $sellerId);
    }

    /**
     * {@inheritdoc}
     */
    public function getProductId(): ?int
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setProductId(int $productId): ProductInterface
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * {@inheritdoc}
     */
    public function getCondition(): ?string
    {
        return $this->getData(self::CONDITION);
    }

    /**
     * {@inheritdoc}
     */
    public function setCondition(string $condition): ProductInterface
    {
        return $this->setData(self::CONDITION, $condition);
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
    public function setIsApproved(int $isApproved): ProductInterface
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
    public function setCreatedAt(string $createdAt): ProductInterface
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
    public function setUpdatedAt(string $updatedAt): ProductInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Check if product is approved
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->getIsApproved() == self::APPROVED;
    }

    /**
     * Check if product is new
     *
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->getCondition() == self::CONDITION_NEW;
    }

    /**
     * Check if product is used
     *
     * @return bool
     */
    public function isUsed(): bool
    {
        return $this->getCondition() == self::CONDITION_USED;
    }

    /**
     * Check if product is refurbished
     *
     * @return bool
     */
    public function isRefurbished(): bool
    {
        return $this->getCondition() == self::CONDITION_REFURBISHED;
    }

    /**
     * Check if product is for parts
     *
     * @return bool
     */
    public function isForParts(): bool
    {
        return $this->getCondition() == self::CONDITION_FOR_PARTS;
    }

    /**
     * Get condition label
     *
     * @return string
     */
    public function getConditionLabel(): string
    {
        $conditionLabels = [
            self::CONDITION_NEW => __('New'),
            self::CONDITION_USED => __('Used'),
            self::CONDITION_REFURBISHED => __('Refurbished'),
            self::CONDITION_FOR_PARTS => __('For Parts')
        ];

        return $conditionLabels[$this->getCondition()] ?? __('Unknown');
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
     * Get available conditions
     *
     * @return array
     */
    public static function getAvailableConditions(): array
    {
        return [
            self::CONDITION_NEW => __('New'),
            self::CONDITION_USED => __('Used'),
            self::CONDITION_REFURBISHED => __('Refurbished'),
            self::CONDITION_FOR_PARTS => __('For Parts')
        ];
    }
}
