<?php
/**
 * NativeMind Marketplace Seller Resource Model
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
 * Class Seller
 * @package NativeMind\Marketplace\Model\ResourceModel
 */
class Seller extends AbstractDb
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
        $this->_init('native_marketplace_seller', 'seller_id');
    }

    /**
     * Load seller by customer ID
     *
     * @param \NativeMind\Marketplace\Model\Seller $seller
     * @param int $customerId
     * @return $this
     */
    public function loadByCustomerId(\NativeMind\Marketplace\Model\Seller $seller, int $customerId)
    {
        $connection = $this->getConnection();
        $bind = ['customer_id' => $customerId];
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('customer_id = :customer_id');

        $sellerId = $connection->fetchOne($select, $bind);
        if ($sellerId) {
            $this->load($seller, $sellerId);
        } else {
            $seller->setData([]);
        }

        return $this;
    }

    /**
     * Load seller by subdomain
     *
     * @param \NativeMind\Marketplace\Model\Seller $seller
     * @param string $subdomain
     * @return $this
     */
    public function loadBySubdomain(\NativeMind\Marketplace\Model\Seller $seller, string $subdomain)
    {
        $connection = $this->getConnection();
        $bind = ['subdomain' => $subdomain];
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('subdomain = :subdomain');

        $sellerId = $connection->fetchOne($select, $bind);
        if ($sellerId) {
            $this->load($seller, $sellerId);
        } else {
            $seller->setData([]);
        }

        return $this;
    }

    /**
     * Check if subdomain exists
     *
     * @param string $subdomain
     * @param int|null $excludeSellerId
     * @return bool
     */
    public function subdomainExists(string $subdomain, ?int $excludeSellerId = null): bool
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable(), ['seller_id'])
            ->where('subdomain = ?', $subdomain);

        if ($excludeSellerId) {
            $select->where('seller_id != ?', $excludeSellerId);
        }

        return (bool) $connection->fetchOne($select);
    }

    /**
     * Get approved sellers
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getApprovedSellers(int $limit = 10, int $offset = 0): array
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('status = ?', \NativeMind\Marketplace\Model\Seller::STATUS_ACTIVE)
            ->where('approval_status = ?', \NativeMind\Marketplace\Model\Seller::APPROVAL_STATUS_APPROVED)
            ->order('created_at DESC')
            ->limit($limit, $offset);

        return $connection->fetchAll($select);
    }

    /**
     * Get pending sellers
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getPendingSellers(int $limit = 10, int $offset = 0): array
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('approval_status = ?', \NativeMind\Marketplace\Model\Seller::APPROVAL_STATUS_PENDING)
            ->order('created_at ASC')
            ->limit($limit, $offset);

        return $connection->fetchAll($select);
    }

    /**
     * Update seller statistics
     *
     * @param int $sellerId
     * @return $this
     */
    public function updateStatistics(int $sellerId)
    {
        $connection = $this->getConnection();

        // Update product count
        $productCount = $connection->fetchOne(
            $connection->select()
                ->from($this->getTable('native_marketplace_seller_product'), ['COUNT(*)'])
                ->where('seller_id = ?', $sellerId)
        );

        // Update review count and rating
        $reviewData = $connection->fetchRow(
            $connection->select()
                ->from($this->getTable('native_marketplace_seller_review'), [
                    'COUNT(*) as review_count',
                    'AVG(rating) as avg_rating'
                ])
                ->where('seller_id = ?', $sellerId)
                ->where('is_approved = ?', 1)
        );

        // Update total sales
        $totalSales = $connection->fetchOne(
            $connection->select()
                ->from($this->getTable('native_marketplace_commission'), ['SUM(commission_amount)'])
                ->where('seller_id = ?', $sellerId)
                ->where('status = ?', 1)
        );

        $connection->update(
            $this->getMainTable(),
            [
                'product_count' => $productCount,
                'review_count' => $reviewData['review_count'] ?? 0,
                'rating' => round($reviewData['avg_rating'] ?? 0, 2),
                'total_sales' => $totalSales ?: 0,
                'updated_at' => $this->dateTime->gmtDate()
            ],
            ['seller_id = ?' => $sellerId]
        );

        return $this;
    }

    /**
     * Get seller statistics
     *
     * @param int $sellerId
     * @return array
     */
    public function getStatistics(int $sellerId): array
    {
        $connection = $this->getConnection();

        $select = $connection->select()
            ->from($this->getMainTable(), [
                'product_count',
                'review_count',
                'rating',
                'total_sales'
            ])
            ->where('seller_id = ?', $sellerId);

        return $connection->fetchRow($select) ?: [];
    }

    /**
     * Get seller by customer ID
     *
     * @param int $customerId
     * @return array|null
     */
    public function getByCustomerId(int $customerId): ?array
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('customer_id = ?', $customerId);

        $result = $connection->fetchRow($select);
        return $result ?: null;
    }

    /**
     * Get seller by subdomain
     *
     * @param string $subdomain
     * @return array|null
     */
    public function getBySubdomain(string $subdomain): ?array
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable())
            ->where('subdomain = ?', $subdomain);

        $result = $connection->fetchRow($select);
        return $result ?: null;
    }
}

