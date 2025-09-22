<?php
/**
 * NativeMind Marketplace Admin Seller Grid Block
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Block\Adminhtml\Seller;

use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use NativeMind\Marketplace\Model\ResourceModel\Seller\CollectionFactory;

/**
 * Class Grid
 * @package NativeMind\Marketplace\Block\Adminhtml\Seller
 */
class Grid extends Extended
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Data $backendHelper
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('marketplace_seller_grid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareCollection()
    {
        $collection = $this->collectionFactory->create();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'seller_id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'seller_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'company_name',
            [
                'header' => __('Company Name'),
                'index' => 'company_name',
                'class' => 'xxx'
            ]
        );

        $this->addColumn(
            'customer_id',
            [
                'header' => __('Customer ID'),
                'type' => 'number',
                'index' => 'customer_id'
            ]
        );

        $this->addColumn(
            'subdomain',
            [
                'header' => __('Subdomain'),
                'index' => 'subdomain'
            ]
        );

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' => [
                    0 => __('Inactive'),
                    1 => __('Active'),
                    2 => __('Suspended')
                ]
            ]
        );

        $this->addColumn(
            'approval_status',
            [
                'header' => __('Approval Status'),
                'index' => 'approval_status',
                'type' => 'options',
                'options' => [
                    0 => __('Pending'),
                    1 => __('Approved'),
                    2 => __('Rejected')
                ]
            ]
        );

        $this->addColumn(
            'rating',
            [
                'header' => __('Rating'),
                'type' => 'number',
                'index' => 'rating',
                'renderer' => \NativeMind\Marketplace\Block\Adminhtml\Seller\Grid\Renderer\Rating::class
            ]
        );

        $this->addColumn(
            'review_count',
            [
                'header' => __('Reviews'),
                'type' => 'number',
                'index' => 'review_count'
            ]
        );

        $this->addColumn(
            'product_count',
            [
                'header' => __('Products'),
                'type' => 'number',
                'index' => 'product_count'
            ]
        );

        $this->addColumn(
            'total_sales',
            [
                'header' => __('Total Sales'),
                'type' => 'currency',
                'index' => 'total_sales',
                'currency_code' => 'USD'
            ]
        );

        $this->addColumn(
            'created_at',
            [
                'header' => __('Created At'),
                'type' => 'datetime',
                'index' => 'created_at'
            ]
        );

        $this->addColumn(
            'action',
            [
                'header' => __('Action'),
                'type' => 'action',
                'getter' => 'getSellerId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => ['base' => '*/*/edit'],
                        'field' => 'seller_id'
                    ],
                    [
                        'caption' => __('Approve'),
                        'url' => ['base' => '*/*/approve'],
                        'field' => 'seller_id',
                        'confirm' => __('Are you sure you want to approve this seller?')
                    ],
                    [
                        'caption' => __('Reject'),
                        'url' => ['base' => '*/*/reject'],
                        'field' => 'seller_id',
                        'confirm' => __('Are you sure you want to reject this seller?')
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('seller_id');
        $this->getMassactionBlock()->setFormFieldName('seller_ids');

        $this->getMassactionBlock()->addItem(
            'approve',
            [
                'label' => __('Approve'),
                'url' => $this->getUrl('*/*/massApprove'),
                'confirm' => __('Are you sure you want to approve selected sellers?')
            ]
        );

        $this->getMassactionBlock()->addItem(
            'reject',
            [
                'label' => __('Reject'),
                'url' => $this->getUrl('*/*/massReject'),
                'confirm' => __('Are you sure you want to reject selected sellers?')
            ]
        );

        $this->getMassactionBlock()->addItem(
            'suspend',
            [
                'label' => __('Suspend'),
                'url' => $this->getUrl('*/*/massSuspend'),
                'confirm' => __('Are you sure you want to suspend selected sellers?')
            ]
        );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}
