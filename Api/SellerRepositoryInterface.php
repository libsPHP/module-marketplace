<?php
/**
 * NativeMind Marketplace Seller Repository Interface
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
use NativeMind\Marketplace\Api\Data\SellerInterface;

/**
 * Interface SellerRepositoryInterface
 * @package NativeMind\Marketplace\Api
 */
interface SellerRepositoryInterface
{
    /**
     * Save seller
     *
     * @param SellerInterface $seller
     * @return SellerInterface
     * @throws CouldNotSaveException
     */
    public function save(SellerInterface $seller): SellerInterface;

    /**
     * Get seller by ID
     *
     * @param int $sellerId
     * @return SellerInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $sellerId): SellerInterface;

    /**
     * Get seller by customer ID
     *
     * @param int $customerId
     * @return SellerInterface
     * @throws NoSuchEntityException
     */
    public function getByCustomerId(int $customerId): SellerInterface;

    /**
     * Get seller by subdomain
     *
     * @param string $subdomain
     * @return SellerInterface
     * @throws NoSuchEntityException
     */
    public function getBySubdomain(string $subdomain): SellerInterface;

    /**
     * Get seller list
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Delete seller
     *
     * @param SellerInterface $seller
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(SellerInterface $seller): bool;

    /**
     * Delete seller by ID
     *
     * @param int $sellerId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $sellerId): bool;

    /**
     * Check if seller exists
     *
     * @param int $sellerId
     * @return bool
     */
    public function exists(int $sellerId): bool;

    /**
     * Get approved sellers
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getApprovedSellers(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get pending sellers
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getPendingSellers(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;
}

