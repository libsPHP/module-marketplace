<?php
/**
 * NativeMind Marketplace Product Repository Interface
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
use NativeMind\Marketplace\Api\Data\ProductInterface;

/**
 * Interface ProductRepositoryInterface
 * @package NativeMind\Marketplace\Api
 */
interface ProductRepositoryInterface
{
    /**
     * Save marketplace product
     *
     * @param ProductInterface $product
     * @return ProductInterface
     * @throws CouldNotSaveException
     */
    public function save(ProductInterface $product): ProductInterface;

    /**
     * Get marketplace product by ID
     *
     * @param int $productId
     * @return ProductInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $productId): ProductInterface;

    /**
     * Get marketplace product by seller and product ID
     *
     * @param int $sellerId
     * @param int $productId
     * @return ProductInterface
     * @throws NoSuchEntityException
     */
    public function getBySellerAndProduct(int $sellerId, int $productId): ProductInterface;

    /**
     * Get marketplace products by seller
     *
     * @param int $sellerId
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getBySeller(int $sellerId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get marketplace product list
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Delete marketplace product
     *
     * @param ProductInterface $product
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ProductInterface $product): bool;

    /**
     * Delete marketplace product by ID
     *
     * @param int $productId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $productId): bool;

    /**
     * Check if marketplace product exists
     *
     * @param int $productId
     * @return bool
     */
    public function exists(int $productId): bool;

    /**
     * Get approved products
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getApprovedProducts(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get pending products
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getPendingProducts(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get products by condition
     *
     * @param string $condition
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getByCondition(string $condition, SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Get products by seller and condition
     *
     * @param int $sellerId
     * @param string $condition
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getBySellerAndCondition(int $sellerId, string $condition, SearchCriteriaInterface $searchCriteria): SearchResultsInterface;
}
