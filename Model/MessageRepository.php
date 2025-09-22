<?php
/**
 * NativeMind Marketplace Message Repository
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
use NativeMind\Marketplace\Api\Data\MessageInterface;
use NativeMind\Marketplace\Api\MessageRepositoryInterface;
use NativeMind\Marketplace\Model\ResourceModel\Message as MessageResource;
use NativeMind\Marketplace\Model\ResourceModel\Message\CollectionFactory;

/**
 * Class MessageRepository
 * @package NativeMind\Marketplace\Model
 */
class MessageRepository implements MessageRepositoryInterface
{
    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /**
     * @var MessageResource
     */
    protected $messageResource;

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
     * @param MessageFactory $messageFactory
     * @param MessageResource $messageResource
     * @param CollectionFactory $collectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        MessageFactory $messageFactory,
        MessageResource $messageResource,
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
    ) {
        $this->messageFactory = $messageFactory;
        $this->messageResource = $messageResource;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function save(MessageInterface $message): MessageInterface
    {
        try {
            $this->messageResource->save($message);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save message: %1', $exception->getMessage()),
                $exception
            );
        }
        return $message;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $messageId): MessageInterface
    {
        $message = $this->messageFactory->create();
        $this->messageResource->load($message, $messageId);
        if (!$message->getMessageId()) {
            throw new NoSuchEntityException(__('Message with id "%1" does not exist.', $messageId));
        }
        return $message;
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
    public function delete(MessageInterface $message): bool
    {
        try {
            $this->messageResource->delete($message);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete message: %1', $exception->getMessage()),
                $exception
            );
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById(int $messageId): bool
    {
        return $this->delete($this->getById($messageId));
    }

    /**
     * {@inheritdoc}
     */
    public function exists(int $messageId): bool
    {
        try {
            $this->getById($messageId);
            return true;
        } catch (NoSuchEntityException $e) {
            return false;
        }
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
    public function getByCustomer(int $customerId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('customer_id', $customerId);
        
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
    public function getByOrder(int $orderId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('order_id', $orderId);
        
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
    public function getConversation(int $sellerId, int $customerId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('seller_id', $sellerId);
        $collection->addFieldToFilter('customer_id', $customerId);
        $collection->setOrder('created_at', 'ASC');
        
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
    public function getUnreadBySeller(int $sellerId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('seller_id', $sellerId);
        $collection->addFieldToFilter('is_read', Message::NOT_READ);
        $collection->addFieldToFilter('is_seller_message', Message::CUSTOMER_MESSAGE);
        
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
    public function getUnreadByCustomer(int $customerId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('customer_id', $customerId);
        $collection->addFieldToFilter('is_read', Message::NOT_READ);
        $collection->addFieldToFilter('is_seller_message', Message::SELLER_MESSAGE);
        
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
    public function getBySellerAndCustomer(int $sellerId, int $customerId, SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('seller_id', $sellerId);
        $collection->addFieldToFilter('customer_id', $customerId);
        
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
