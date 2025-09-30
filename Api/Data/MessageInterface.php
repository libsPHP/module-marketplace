<?php
/**
 * NativeMind Marketplace Message Data Interface
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Api\Data;

/**
 * Interface MessageInterface
 * @package NativeMind\Marketplace\Api\Data
 */
interface MessageInterface
{
    const MESSAGE_ID = 'message_id';
    const SELLER_ID = 'seller_id';
    const CUSTOMER_ID = 'customer_id';
    const ORDER_ID = 'order_id';
    const SUBJECT = 'subject';
    const MESSAGE = 'message';
    const IS_READ = 'is_read';
    const IS_SELLER_MESSAGE = 'is_seller_message';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Get message ID
     *
     * @return int|null
     */
    public function getMessageId(): ?int;

    /**
     * Set message ID
     *
     * @param int $messageId
     * @return MessageInterface
     */
    public function setMessageId(int $messageId): MessageInterface;

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
     * @return MessageInterface
     */
    public function setSellerId(int $sellerId): MessageInterface;

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
     * @return MessageInterface
     */
    public function setCustomerId(int $customerId): MessageInterface;

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
     * @return MessageInterface
     */
    public function setOrderId(int $orderId): MessageInterface;

    /**
     * Get subject
     *
     * @return string|null
     */
    public function getSubject(): ?string;

    /**
     * Set subject
     *
     * @param string $subject
     * @return MessageInterface
     */
    public function setSubject(string $subject): MessageInterface;

    /**
     * Get message
     *
     * @return string|null
     */
    public function getMessage(): ?string;

    /**
     * Set message
     *
     * @param string $message
     * @return MessageInterface
     */
    public function setMessage(string $message): MessageInterface;

    /**
     * Get is read
     *
     * @return int|null
     */
    public function getIsRead(): ?int;

    /**
     * Set is read
     *
     * @param int $isRead
     * @return MessageInterface
     */
    public function setIsRead(int $isRead): MessageInterface;

    /**
     * Get is seller message
     *
     * @return int|null
     */
    public function getIsSellerMessage(): ?int;

    /**
     * Set is seller message
     *
     * @param int $isSellerMessage
     * @return MessageInterface
     */
    public function setIsSellerMessage(int $isSellerMessage): MessageInterface;

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
     * @return MessageInterface
     */
    public function setCreatedAt(string $createdAt): MessageInterface;

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
     * @return MessageInterface
     */
    public function setUpdatedAt(string $updatedAt): MessageInterface;
}

