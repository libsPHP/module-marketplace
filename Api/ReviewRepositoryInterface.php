<?php
/**
 * NativeMind Marketplace Review Repository Interface
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
use NativeMind\Marketplace\Api\Data\ReviewInterface;

/**
 * Interface ReviewRepositoryInterface
 * @package NativeMind\Marketplace\Api
 */
interface ReviewRepositoryInterface
{
    /**
     * Save review
     *
     * @param ReviewInterface $review
     * @return ReviewInterface
     * @throws CouldNotSaveException
     */
    public function save(ReviewInterface $review): ReviewInterface;

    /**
     * Get review by ID
     *
     * @param int $reviewId
     * @return ReviewInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $reviewId): ReviewInterface;

    /**
     * Get review list
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Delete review
     *
     * @param ReviewInterface $review
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ReviewInterface $review): bool;

    /**
     * Delete review by ID
     *
     * @param int $reviewId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $reviewId): bool;

    /**
     * Check if review exists
     *
     * @param int $reviewId
     * @return bool
     */
    public function exists(int $reviewId): bool;

    /**
     * Get reviews by seller
     *
     * @param int $sellerId
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getBySeller(int $sellerId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get reviews by customer
     *
     * @param int $customerId
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getByCustomer(int $customerId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get reviews by order
     *
     * @param int $orderId
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getByOrder(int $orderId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get approved reviews
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getApprovedReviews(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get pending reviews
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getPendingReviews(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get reviews by rating
     *
     * @param int $rating
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getByRating(int $rating, SearchCriteriaInterface $searchCriteria): SearchResultsInterface;
}
