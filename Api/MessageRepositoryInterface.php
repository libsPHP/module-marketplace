<?php
/**
 * NativeMind Marketplace Message Repository Interface
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use NativeMind\Marketplace\Api\Data\MessageInterface;

/**
 * Interface MessageRepositoryInterface
 * @package NativeMind\Marketplace\Api
 */
interface MessageRepositoryInterface
{
    /**
     * Save message
     *
     * @param MessageInterface $message
     * @return MessageInterface
     * @throws CouldNotSaveException
     */
    public function save(MessageInterface $message): MessageInterface;

    /**
     * Get message by ID
     *
     * @param int $messageId
     * @return MessageInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $messageId): MessageInterface;

    /**
     * Get message list
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Delete message
     *
     * @param MessageInterface $message
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(MessageInterface $message): bool;

    /**
     * Delete message by ID
     *
     * @param int $messageId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $messageId): bool;

    /**
     * Check if message exists
     *
     * @param int $messageId
     * @return bool
     */
    public function exists(int $messageId): bool;

    /**
     * Get messages by seller
     *
     * @param int $sellerId
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getBySeller(int $sellerId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get messages by customer
     *
     * @param int $customerId
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getByCustomer(int $customerId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get messages by order
     *
     * @param int $orderId
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getByOrder(int $orderId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get conversation between seller and customer
     *
     * @param int $sellerId
     * @param int $customerId
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getConversation(int $sellerId, int $customerId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get unread messages for seller
     *
     * @param int $sellerId
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getUnreadBySeller(int $sellerId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get unread messages for customer
     *
     * @param int $customerId
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getUnreadByCustomer(int $customerId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get messages by seller and customer
     *
     * @param int $sellerId
     * @param int $customerId
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getBySellerAndCustomer(int $sellerId, int $customerId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface;
}

