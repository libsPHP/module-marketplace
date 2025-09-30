<?php
/**
 * NativeMind Marketplace Product Resource Model
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * Class Product
 * @package NativeMind\Marketplace\Model\ResourceModel
 */
class Product extends AbstractDb
{
    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * Constructor
     *
     * @param Context $context
     * @param DateTime $dateTime
     * @param string $connectionName
     */
    public function __construct(
        Context $context,
        DateTime $dateTime,
        $connectionName = null
    ) {
        $this->dateTime = $dateTime;
        parent::__construct($context, $connectionName);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('native_marketplace_seller_product', 'id');
    }

    /**
     * Load product by seller and product ID
     *
     * @param \NativeMind\Marketplace\Model\Product $product
     * @param int $sellerId
     * @param int $productId
     * @return $this
     */
    public function loadBySellerAndProduct(\NativeMind\Marketplace\Model\Product $product, int $sellerId, int $productId)
    {
        $connection = $this->getConnection();
        $bind = [
            'seller_id' => $sellerId,
            'product_id' => $productId
        ];
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('seller_id = :seller_id')
            ->where('product_id = :product_id');

        $id = $connection->fetchOne($select, $bind);
        if ($id) {
            $this->load($product, $id);
        } else {
            $product->setData([]);
        }

        return $this;
    }

    /**
     * Check if product exists for seller
     *
     * @param int $sellerId
     * @param int $productId
     * @return bool
     */
    public function productExistsForSeller(int $sellerId, int $productId): bool
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable(), ['id'])
            ->where('seller_id = ?', $sellerId)
            ->where('product_id = ?', $productId);

        return (bool) $connection->fetchOne($select);
    }

    /**
     * Get products by seller
     *
     * @param int $sellerId
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getProductsBySeller(int $sellerId, int $limit = 10, int $offset = 0): array
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('seller_id = ?', $sellerId)
            ->order('created_at DESC')
            ->limit($limit, $offset);

        return $connection->fetchAll($select);
    }

    /**
     * Get approved products by seller
     *
     * @param int $sellerId
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getApprovedProductsBySeller(int $sellerId, int $limit = 10, int $offset = 0): array
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('seller_id = ?', $sellerId)
            ->where('is_approved = ?', \NativeMind\Marketplace\Model\Product::APPROVED)
            ->order('created_at DESC')
            ->limit($limit, $offset);

        return $connection->fetchAll($select);
    }

    /**
     * Get pending products by seller
     *
     * @param int $sellerId
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getPendingProductsBySeller(int $sellerId, int $limit = 10, int $offset = 0): array
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('seller_id = ?', $sellerId)
            ->where('is_approved = ?', \NativeMind\Marketplace\Model\Product::NOT_APPROVED)
            ->order('created_at DESC')
            ->limit($limit, $offset);

        return $connection->fetchAll($select);
    }

    /**
     * Get products by condition
     *
     * @param string $condition
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getProductsByCondition(string $condition, int $limit = 10, int $offset = 0): array
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('condition = ?', $condition)
            ->where('is_approved = ?', \NativeMind\Marketplace\Model\Product::APPROVED)
            ->order('created_at DESC')
            ->limit($limit, $offset);

        return $connection->fetchAll($select);
    }

    /**
     * Get products by seller and condition
     *
     * @param int $sellerId
     * @param string $condition
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getProductsBySellerAndCondition(int $sellerId, string $condition, int $limit = 10, int $offset = 0): array
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('seller_id = ?', $sellerId)
            ->where('condition = ?', $condition)
            ->where('is_approved = ?', \NativeMind\Marketplace\Model\Product::APPROVED)
            ->order('created_at DESC')
            ->limit($limit, $offset);

        return $connection->fetchAll($select);
    }

    /**
     * Get all approved products
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllApprovedProducts(int $limit = 10, int $offset = 0): array
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('is_approved = ?', \NativeMind\Marketplace\Model\Product::APPROVED)
            ->order('created_at DESC')
            ->limit($limit, $offset);

        return $connection->fetchAll($select);
    }

    /**
     * Get all pending products
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllPendingProducts(int $limit = 10, int $offset = 0): array
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('is_approved = ?', \NativeMind\Marketplace\Model\Product::NOT_APPROVED)
            ->order('created_at ASC')
            ->limit($limit, $offset);

        return $connection->fetchAll($select);
    }

    /**
     * Get product count by seller
     *
     * @param int $sellerId
     * @return int
     */
    public function getProductCountBySeller(int $sellerId): int
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable(), ['COUNT(*)'])
            ->where('seller_id = ?', $sellerId);

        return (int) $connection->fetchOne($select);
    }

    /**
     * Get approved product count by seller
     *
     * @param int $sellerId
     * @return int
     */
    public function getApprovedProductCountBySeller(int $sellerId): int
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable(), ['COUNT(*)'])
            ->where('seller_id = ?', $sellerId)
            ->where('is_approved = ?', \NativeMind\Marketplace\Model\Product::APPROVED);

        return (int) $connection->fetchOne($select);
    }

    /**
     * Get pending product count by seller
     *
     * @param int $sellerId
     * @return int
     */
    public function getPendingProductCountBySeller(int $sellerId): int
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable(), ['COUNT(*)'])
            ->where('seller_id = ?', $sellerId)
            ->where('is_approved = ?', \NativeMind\Marketplace\Model\Product::NOT_APPROVED);

        return (int) $connection->fetchOne($select);
    }

    /**
     * Get product statistics by seller
     *
     * @param int $sellerId
     * @return array
     */
    public function getProductStatisticsBySeller(int $sellerId): array
    {
        $connection = $this->getConnection();
        
        $select = $connection->select()
            ->from($this->getMainTable(), [
                'total_products' => 'COUNT(*)',
                'approved_products' => 'SUM(CASE WHEN is_approved = 1 THEN 1 ELSE 0 END)',
                'pending_products' => 'SUM(CASE WHEN is_approved = 0 THEN 1 ELSE 0 END)',
                'new_products' => 'SUM(CASE WHEN condition = "new" THEN 1 ELSE 0 END)',
                'used_products' => 'SUM(CASE WHEN condition = "used" THEN 1 ELSE 0 END)',
                'refurbished_products' => 'SUM(CASE WHEN condition = "refurbished" THEN 1 ELSE 0 END)',
                'for_parts_products' => 'SUM(CASE WHEN condition = "for_parts" THEN 1 ELSE 0 END)'
            ])
            ->where('seller_id = ?', $sellerId);

        $result = $connection->fetchRow($select);
        return $result ?: [
            'total_products' => 0,
            'approved_products' => 0,
            'pending_products' => 0,
            'new_products' => 0,
            'used_products' => 0,
            'refurbished_products' => 0,
            'for_parts_products' => 0
        ];
    }

    /**
     * Approve product
     *
     * @param int $id
     * @return $this
     */
    public function approveProduct(int $id)
    {
        $connection = $this->getConnection();
        $connection->update(
            $this->getMainTable(),
            [
                'is_approved' => \NativeMind\Marketplace\Model\Product::APPROVED,
                'updated_at' => $this->dateTime->gmtDate()
            ],
            ['id = ?' => $id]
        );

        return $this;
    }

    /**
     * Reject product
     *
     * @param int $id
     * @return $this
     */
    public function rejectProduct(int $id)
    {
        $connection = $this->getConnection();
        $connection->update(
            $this->getMainTable(),
            [
                'is_approved' => \NativeMind\Marketplace\Model\Product::NOT_APPROVED,
                'updated_at' => $this->dateTime->gmtDate()
            ],
            ['id = ?' => $id]
        );

        return $this;
    }
}

