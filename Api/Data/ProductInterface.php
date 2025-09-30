<?php
/**
 * NativeMind Marketplace Product Data Interface
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Api\Data;

/**
 * Interface ProductInterface
 * @package NativeMind\Marketplace\Api\Data
 */
interface ProductInterface
{
    const ID = 'id';
    const SELLER_ID = 'seller_id';
    const PRODUCT_ID = 'product_id';
    const CONDITION = 'condition';
    const IS_APPROVED = 'is_approved';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Set ID
     *
     * @param int $id
     * @return ProductInterface
     */
    public function setId(int $id): ProductInterface;

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
     * @return ProductInterface
     */
    public function setSellerId(int $sellerId): ProductInterface;

    /**
     * Get product ID
     *
     * @return int|null
     */
    public function getProductId(): ?int;

    /**
     * Set product ID
     *
     * @param int $productId
     * @return ProductInterface
     */
    public function setProductId(int $productId): ProductInterface;

    /**
     * Get condition
     *
     * @return string|null
     */
    public function getCondition(): ?string;

    /**
     * Set condition
     *
     * @param string $condition
     * @return ProductInterface
     */
    public function setCondition(string $condition): ProductInterface;

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
     * @return ProductInterface
     */
    public function setIsApproved(int $isApproved): ProductInterface;

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
     * @return ProductInterface
     */
    public function setCreatedAt(string $createdAt): ProductInterface;

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
     * @return ProductInterface
     */
    public function setUpdatedAt(string $updatedAt): ProductInterface;
}

