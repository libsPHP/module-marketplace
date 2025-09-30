<?php
/**
 * NativeMind Marketplace Module Install Schema
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class InstallSchema
 * @package NativeMind\Marketplace\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // Create seller table
        $this->createSellerTable($installer);
        
        // Create seller product table
        $this->createSellerProductTable($installer);
        
        // Create seller review table
        $this->createSellerReviewTable($installer);
        
        // Create seller message table
        $this->createSellerMessageTable($installer);
        
        // Create commission table
        $this->createCommissionTable($installer);
        
        // Create seller store table
        $this->createSellerStoreTable($installer);

        $installer->endSetup();
    }

    /**
     * Create seller table
     *
     * @param SchemaSetupInterface $installer
     * @return void
     */
    private function createSellerTable(SchemaSetupInterface $installer)
    {
        $table = $installer->getConnection()->newTable(
            $installer->getTable('native_marketplace_seller')
        )->addColumn(
            'seller_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Seller ID'
        )->addColumn(
            'customer_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Customer ID'
        )->addColumn(
            'company_name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Company Name'
        )->addColumn(
            'business_license',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Business License'
        )->addColumn(
            'tax_id',
            Table::TYPE_TEXT,
            50,
            ['nullable' => true],
            'Tax ID'
        )->addColumn(
            'phone',
            Table::TYPE_TEXT,
            50,
            ['nullable' => true],
            'Phone'
        )->addColumn(
            'address',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Address'
        )->addColumn(
            'city',
            Table::TYPE_TEXT,
            100,
            ['nullable' => true],
            'City'
        )->addColumn(
            'region',
            Table::TYPE_TEXT,
            100,
            ['nullable' => true],
            'Region'
        )->addColumn(
            'postcode',
            Table::TYPE_TEXT,
            20,
            ['nullable' => true],
            'Postcode'
        )->addColumn(
            'country_id',
            Table::TYPE_TEXT,
            2,
            ['nullable' => true],
            'Country ID'
        )->addColumn(
            'subdomain',
            Table::TYPE_TEXT,
            100,
            ['nullable' => true],
            'Subdomain'
        )->addColumn(
            'status',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => 1],
            'Status'
        )->addColumn(
            'approval_status',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => 0],
            'Approval Status'
        )->addColumn(
            'commission_rate',
            Table::TYPE_DECIMAL,
            '5,2',
            ['nullable' => false, 'default' => '5.00'],
            'Commission Rate'
        )->addColumn(
            'rating',
            Table::TYPE_DECIMAL,
            '3,2',
            ['nullable' => false, 'default' => '0.00'],
            'Rating'
        )->addColumn(
            'review_count',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => 0],
            'Review Count'
        )->addColumn(
            'product_count',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => 0],
            'Product Count'
        )->addColumn(
            'total_sales',
            Table::TYPE_DECIMAL,
            '12,4',
            ['nullable' => false, 'default' => '0.0000'],
            'Total Sales'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created At'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Updated At'
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller', ['customer_id']),
            ['customer_id']
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller', ['subdomain']),
            ['subdomain']
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller', ['status']),
            ['status']
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller', ['approval_status']),
            ['approval_status']
        )->addForeignKey(
            $installer->getFkName('native_marketplace_seller', 'customer_id', 'customer_entity', 'entity_id'),
            'customer_id',
            $installer->getTable('customer_entity'),
            'entity_id',
            Table::ACTION_CASCADE
        )->setComment(
            'NativeMind Marketplace Seller Table'
        );

        $installer->getConnection()->createTable($table);
    }

    /**
     * Create seller product table
     *
     * @param SchemaSetupInterface $installer
     * @return void
     */
    private function createSellerProductTable(SchemaSetupInterface $installer)
    {
        $table = $installer->getConnection()->newTable(
            $installer->getTable('native_marketplace_seller_product')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'ID'
        )->addColumn(
            'seller_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Seller ID'
        )->addColumn(
            'product_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Product ID'
        )->addColumn(
            'condition',
            Table::TYPE_TEXT,
            20,
            ['nullable' => false, 'default' => 'new'],
            'Product Condition'
        )->addColumn(
            'is_approved',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => 0],
            'Is Approved'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created At'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Updated At'
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller_product', ['seller_id']),
            ['seller_id']
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller_product', ['product_id']),
            ['product_id']
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller_product', ['is_approved']),
            ['is_approved']
        )->addForeignKey(
            $installer->getFkName('native_marketplace_seller_product', 'seller_id', 'native_marketplace_seller', 'seller_id'),
            'seller_id',
            $installer->getTable('native_marketplace_seller'),
            'seller_id',
            Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('native_marketplace_seller_product', 'product_id', 'catalog_product_entity', 'entity_id'),
            'product_id',
            $installer->getTable('catalog_product_entity'),
            'entity_id',
            Table::ACTION_CASCADE
        )->setComment(
            'NativeMind Marketplace Seller Product Table'
        );

        $installer->getConnection()->createTable($table);
    }

    /**
     * Create seller review table
     *
     * @param SchemaSetupInterface $installer
     * @return void
     */
    private function createSellerReviewTable(SchemaSetupInterface $installer)
    {
        $table = $installer->getConnection()->newTable(
            $installer->getTable('native_marketplace_seller_review')
        )->addColumn(
            'review_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Review ID'
        )->addColumn(
            'seller_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Seller ID'
        )->addColumn(
            'customer_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Customer ID'
        )->addColumn(
            'order_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => true],
            'Order ID'
        )->addColumn(
            'rating',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Rating'
        )->addColumn(
            'title',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Review Title'
        )->addColumn(
            'comment',
            Table::TYPE_TEXT,
            '64k',
            ['nullable' => true],
            'Review Comment'
        )->addColumn(
            'is_approved',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => 0],
            'Is Approved'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created At'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Updated At'
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller_review', ['seller_id']),
            ['seller_id']
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller_review', ['customer_id']),
            ['customer_id']
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller_review', ['order_id']),
            ['order_id']
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller_review', ['is_approved']),
            ['is_approved']
        )->addForeignKey(
            $installer->getFkName('native_marketplace_seller_review', 'seller_id', 'native_marketplace_seller', 'seller_id'),
            'seller_id',
            $installer->getTable('native_marketplace_seller'),
            'seller_id',
            Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('native_marketplace_seller_review', 'customer_id', 'customer_entity', 'entity_id'),
            'customer_id',
            $installer->getTable('customer_entity'),
            'entity_id',
            Table::ACTION_CASCADE
        )->setComment(
            'NativeMind Marketplace Seller Review Table'
        );

        $installer->getConnection()->createTable($table);
    }

    /**
     * Create seller message table
     *
     * @param SchemaSetupInterface $installer
     * @return void
     */
    private function createSellerMessageTable(SchemaSetupInterface $installer)
    {
        $table = $installer->getConnection()->newTable(
            $installer->getTable('native_marketplace_seller_message')
        )->addColumn(
            'message_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Message ID'
        )->addColumn(
            'seller_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Seller ID'
        )->addColumn(
            'customer_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Customer ID'
        )->addColumn(
            'order_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => true],
            'Order ID'
        )->addColumn(
            'subject',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Message Subject'
        )->addColumn(
            'message',
            Table::TYPE_TEXT,
            '64k',
            ['nullable' => false],
            'Message Content'
        )->addColumn(
            'is_read',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => 0],
            'Is Read'
        )->addColumn(
            'is_seller_message',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => 0],
            'Is Seller Message'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created At'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Updated At'
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller_message', ['seller_id']),
            ['seller_id']
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller_message', ['customer_id']),
            ['customer_id']
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller_message', ['order_id']),
            ['order_id']
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller_message', ['is_read']),
            ['is_read']
        )->addForeignKey(
            $installer->getFkName('native_marketplace_seller_message', 'seller_id', 'native_marketplace_seller', 'seller_id'),
            'seller_id',
            $installer->getTable('native_marketplace_seller'),
            'seller_id',
            Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('native_marketplace_seller_message', 'customer_id', 'customer_entity', 'entity_id'),
            'customer_id',
            $installer->getTable('customer_entity'),
            'entity_id',
            Table::ACTION_CASCADE
        )->setComment(
            'NativeMind Marketplace Seller Message Table'
        );

        $installer->getConnection()->createTable($table);
    }

    /**
     * Create commission table
     *
     * @param SchemaSetupInterface $installer
     * @return void
     */
    private function createCommissionTable(SchemaSetupInterface $installer)
    {
        $table = $installer->getConnection()->newTable(
            $installer->getTable('native_marketplace_commission')
        )->addColumn(
            'commission_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Commission ID'
        )->addColumn(
            'seller_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Seller ID'
        )->addColumn(
            'order_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Order ID'
        )->addColumn(
            'commission_rate',
            Table::TYPE_DECIMAL,
            '5,2',
            ['nullable' => false],
            'Commission Rate'
        )->addColumn(
            'commission_amount',
            Table::TYPE_DECIMAL,
            '12,4',
            ['nullable' => false],
            'Commission Amount'
        )->addColumn(
            'order_total',
            Table::TYPE_DECIMAL,
            '12,4',
            ['nullable' => false],
            'Order Total'
        )->addColumn(
            'status',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => 0],
            'Status'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created At'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Updated At'
        )->addIndex(
            $installer->getIdxName('native_marketplace_commission', ['seller_id']),
            ['seller_id']
        )->addIndex(
            $installer->getIdxName('native_marketplace_commission', ['order_id']),
            ['order_id']
        )->addIndex(
            $installer->getIdxName('native_marketplace_commission', ['status']),
            ['status']
        )->addForeignKey(
            $installer->getFkName('native_marketplace_commission', 'seller_id', 'native_marketplace_seller', 'seller_id'),
            'seller_id',
            $installer->getTable('native_marketplace_seller'),
            'seller_id',
            Table::ACTION_CASCADE
        )->setComment(
            'NativeMind Marketplace Commission Table'
        );

        $installer->getConnection()->createTable($table);
    }

    /**
     * Create seller store table
     *
     * @param SchemaSetupInterface $installer
     * @return void
     */
    private function createSellerStoreTable(SchemaSetupInterface $installer)
    {
        $table = $installer->getConnection()->newTable(
            $installer->getTable('native_marketplace_seller_store')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'ID'
        )->addColumn(
            'seller_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Seller ID'
        )->addColumn(
            'store_id',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Store ID'
        )->addColumn(
            'subdomain',
            Table::TYPE_TEXT,
            100,
            ['nullable' => true],
            'Subdomain'
        )->addColumn(
            'theme',
            Table::TYPE_TEXT,
            100,
            ['nullable' => true],
            'Theme'
        )->addColumn(
            'logo',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Logo'
        )->addColumn(
            'banner',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Banner'
        )->addColumn(
            'description',
            Table::TYPE_TEXT,
            '64k',
            ['nullable' => true],
            'Description'
        )->addColumn(
            'meta_title',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Meta Title'
        )->addColumn(
            'meta_description',
            Table::TYPE_TEXT,
            '64k',
            ['nullable' => true],
            'Meta Description'
        )->addColumn(
            'meta_keywords',
            Table::TYPE_TEXT,
            '64k',
            ['nullable' => true],
            'Meta Keywords'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Created At'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Updated At'
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller_store', ['seller_id']),
            ['seller_id']
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller_store', ['store_id']),
            ['store_id']
        )->addIndex(
            $installer->getIdxName('native_marketplace_seller_store', ['subdomain']),
            ['subdomain']
        )->addForeignKey(
            $installer->getFkName('native_marketplace_seller_store', 'seller_id', 'native_marketplace_seller', 'seller_id'),
            'seller_id',
            $installer->getTable('native_marketplace_seller'),
            'seller_id',
            Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('native_marketplace_seller_store', 'store_id', 'store', 'store_id'),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            Table::ACTION_CASCADE
        )->setComment(
            'NativeMind Marketplace Seller Store Table'
        );

        $installer->getConnection()->createTable($table);
    }
}

