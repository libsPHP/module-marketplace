<?php
/**
 * NativeMind Marketplace Message Management Interface
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Api;

use NativeMind\Marketplace\Api\Data\MessageInterface;

/**
 * Interface MessageManagementInterface
 * @package NativeMind\Marketplace\Api
 */
interface MessageManagementInterface
{
    /**
     * Send message
     *
     * @param array $messageData
     * @return MessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function sendMessage(array $messageData): MessageInterface;

    /**
     * Reply to message
     *
     * @param int $messageId
     * @param array $replyData
     * @return MessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function replyToMessage(int $messageId, array $replyData): MessageInterface;

    /**
     * Mark message as read
     *
     * @param int $messageId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function markAsRead(int $messageId): bool;

    /**
     * Mark message as unread
     *
     * @param int $messageId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function markAsUnread(int $messageId): bool;

    /**
     * Mark all messages as read
     *
     * @param int $userId
     * @param bool $isSeller
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function markAllAsRead(int $userId, bool $isSeller = false): bool;

    /**
     * Delete message
     *
     * @param int $messageId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteMessage(int $messageId): bool;

    /**
     * Get conversation
     *
     * @param int $sellerId
     * @param int $customerId
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getConversation(int $sellerId, int $customerId, int $limit = 50, int $offset = 0): array;

    /**
     * Get unread message count
     *
     * @param int $userId
     * @param bool $isSeller
     * @return int
     */
    public function getUnreadMessageCount(int $userId, bool $isSeller = false): int;

    /**
     * Get message threads
     *
     * @param int $userId
     * @param bool $isSeller
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getMessageThreads(int $userId, bool $isSeller = false, int $limit = 20, int $offset = 0): array;

    /**
     * Get recent messages
     *
     * @param int $userId
     * @param bool $isSeller
     * @param int $limit
     * @return array
     */
    public function getRecentMessages(int $userId, bool $isSeller = false, int $limit = 10): array;

    /**
     * Check if messaging is allowed
     *
     * @param int $sellerId
     * @param int $customerId
     * @return bool
     */
    public function isMessagingAllowed(int $sellerId, int $customerId): bool;

    /**
     * Validate message data
     *
     * @param array $messageData
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function validateMessageData(array $messageData): bool;

    /**
     * Get message statistics
     *
     * @param int $userId
     * @param bool $isSeller
     * @return array
     */
    public function getMessageStatistics(int $userId, bool $isSeller = false): array;

    /**
     * Search messages
     *
     * @param int $userId
     * @param string $query
     * @param bool $isSeller
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function searchMessages(int $userId, string $query, bool $isSeller = false, int $limit = 20, int $offset = 0): array;

    /**
     * Archive conversation
     *
     * @param int $sellerId
     * @param int $customerId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function archiveConversation(int $sellerId, int $customerId): bool;

    /**
     * Unarchive conversation
     *
     * @param int $sellerId
     * @param int $customerId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function unarchiveConversation(int $sellerId, int $customerId): bool;

    /**
     * Get archived conversations
     *
     * @param int $userId
     * @param bool $isSeller
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getArchivedConversations(int $userId, bool $isSeller = false, int $limit = 20, int $offset = 0): array;
}
