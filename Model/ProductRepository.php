<?php
/**
 * NativeMind Marketplace Product Repository
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use NativeMind\Marketplace\Api\Data\ProductInterface;
use NativeMind\Marketplace\Api\ProductRepositoryInterface;
use NativeMind\Marketplace\Model\ResourceModel\Product as ProductResource;
use NativeMind\Marketplace\Model\ResourceModel\Product\CollectionFactory;

/**
 * Class ProductRepository
 * @package NativeMind\Marketplace\Model
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var ProductResource
     */
    protected $productResource;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var SearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * Constructor
     *
     * @param ProductFactory $productFactory
     * @param ProductResource $productResource
     * @param CollectionFactory $collectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ProductFactory $productFactory,
        ProductResource $productResource,
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
    ) {
        $this->productFactory = $productFactory;
        $this->productResource = $productResource;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function save(ProductInterface $product): ProductInterface
    {
        try {
            $this->productResource->save($product);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save marketplace product: %1', $exception->getMessage()),
                $exception
            );
        }
        return $product;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $productId): ProductInterface
    {
        $product = $this->productFactory->create();
        $this->productResource->load($product, $productId);
        if (!$product->getId()) {
            throw new NoSuchEntityException(__('Marketplace product with id "%1" does not exist.', $productId));
        }
        return $product;
    }

    /**
     * {@inheritdoc}
     */
    public function getBySellerAndProduct(int $sellerId, int $productId): ProductInterface
    {
        $product = $this->productFactory->create();
        $this->productResource->loadBySellerAndProduct($product, $sellerId, $productId);
        if (!$product->getId()) {
            throw new NoSuchEntityException(__('Marketplace product with seller id "%1" and product id "%2" does not exist.', $sellerId, $productId));
        }
        return $product;
    }

    /**
     * {@inheritdoc}
     */
    public function getBySeller(int $sellerId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('seller_id', $sellerId);
        
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ProductInterface $product): bool
    {
        try {
            $this->productResource->delete($product);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete marketplace product: %1', $exception->getMessage()),
                $exception
            );
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById(int $productId): bool
    {
        return $this->delete($this->getById($productId));
    }

    /**
     * {@inheritdoc}
     */
    public function exists(int $productId): bool
    {
        try {
            $this->getById($productId);
            return true;
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getApprovedProducts(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('is_approved', Product::APPROVED);
        
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function getPendingProducts(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('is_approved', Product::NOT_APPROVED);
        
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function getByCondition(string $condition, SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('condition', $condition);
        $collection->addFieldToFilter('is_approved', Product::APPROVED);
        
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function getBySellerAndCondition(int $sellerId, string $condition, SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('seller_id', $sellerId);
        $collection->addFieldToFilter('condition', $condition);
        $collection->addFieldToFilter('is_approved', Product::APPROVED);
        
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}

