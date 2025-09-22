<?php
/**
 * NativeMind Marketplace Message Model
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Model;

use Magento\Framework\Model\AbstractModel;
use NativeMind\Marketplace\Api\Data\MessageInterface;

/**
 * Class Message
 * @package NativeMind\Marketplace\Model
 */
class Message extends AbstractModel implements MessageInterface
{
    /**
     * Read status constants
     */
    const NOT_READ = 0;
    const READ = 1;

    /**
     * Message type constants
     */
    const CUSTOMER_MESSAGE = 0;
    const SELLER_MESSAGE = 1;

    /**
     * @var string
     */
    protected $_eventPrefix = 'native_marketplace_message';

    /**
     * @var string
     */
    protected $_eventObject = 'message';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\NativeMind\Marketplace\Model\ResourceModel\Message::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getMessageId(): ?int
    {
        return $this->getData(self::MESSAGE_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setMessageId(int $messageId): MessageInterface
    {
        return $this->setData(self::MESSAGE_ID, $messageId);
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
    public function setSellerId(int $sellerId): MessageInterface
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
    public function setCustomerId(int $customerId): MessageInterface
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
    public function setOrderId(int $orderId): MessageInterface
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject(): ?string
    {
        return $this->getData(self::SUBJECT);
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject(string $subject): MessageInterface
    {
        return $this->setData(self::SUBJECT, $subject);
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage(): ?string
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage(string $message): MessageInterface
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * {@inheritdoc}
     */
    public function getIsRead(): ?int
    {
        return $this->getData(self::IS_READ);
    }

    /**
     * {@inheritdoc}
     */
    public function setIsRead(int $isRead): MessageInterface
    {
        return $this->setData(self::IS_READ, $isRead);
    }

    /**
     * {@inheritdoc}
     */
    public function getIsSellerMessage(): ?int
    {
        return $this->getData(self::IS_SELLER_MESSAGE);
    }

    /**
     * {@inheritdoc}
     */
    public function setIsSellerMessage(int $isSellerMessage): MessageInterface
    {
        return $this->setData(self::IS_SELLER_MESSAGE, $isSellerMessage);
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
    public function setCreatedAt(string $createdAt): MessageInterface
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
    public function setUpdatedAt(string $updatedAt): MessageInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Check if message is read
     *
     * @return bool
     */
    public function isRead(): bool
    {
        return $this->getIsRead() == self::READ;
    }

    /**
     * Check if message is unread
     *
     * @return bool
     */
    public function isUnread(): bool
    {
        return $this->getIsRead() == self::NOT_READ;
    }

    /**
     * Check if message is from seller
     *
     * @return bool
     */
    public function isFromSeller(): bool
    {
        return $this->getIsSellerMessage() == self::SELLER_MESSAGE;
    }

    /**
     * Check if message is from customer
     *
     * @return bool
     */
    public function isFromCustomer(): bool
    {
        return $this->getIsSellerMessage() == self::CUSTOMER_MESSAGE;
    }

    /**
     * Get read status label
     *
     * @return string
     */
    public function getReadStatusLabel(): string
    {
        return $this->isRead() ? __('Read') : __('Unread');
    }

    /**
     * Get message type label
     *
     * @return string
     */
    public function getMessageTypeLabel(): string
    {
        return $this->isFromSeller() ? __('From Seller') : __('From Customer');
    }

    /**
     * Mark message as read
     *
     * @return MessageInterface
     */
    public function markAsRead(): MessageInterface
    {
        return $this->setIsRead(self::READ);
    }

    /**
     * Mark message as unread
     *
     * @return MessageInterface
     */
    public function markAsUnread(): MessageInterface
    {
        return $this->setIsRead(self::NOT_READ);
    }
}
