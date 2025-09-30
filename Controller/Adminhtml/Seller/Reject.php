<?php
/**
 * NativeMind Marketplace Admin Seller Reject Controller
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Controller\Adminhtml\Seller;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use NativeMind\Marketplace\Api\SellerManagementInterface;

/**
 * Class Reject
 * @package NativeMind\Marketplace\Controller\Adminhtml\Seller
 */
class Reject extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'NativeMind_Marketplace::sellers';

    /**
     * @var SellerManagementInterface
     */
    protected $sellerManagement;

    /**
     * Constructor
     *
     * @param Context $context
     * @param SellerManagementInterface $sellerManagement
     */
    public function __construct(
        Context $context,
        SellerManagementInterface $sellerManagement
    ) {
        $this->sellerManagement = $sellerManagement;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return Redirect
     */
    public function execute()
    {
        $sellerId = $this->getRequest()->getParam('seller_id');
        $reason = $this->getRequest()->getParam('reason', '');
        
        if (!$sellerId) {
            $this->messageManager->addErrorMessage(__('Seller ID is required.'));
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        try {
            $this->sellerManagement->reject($sellerId, $reason);
            $this->messageManager->addSuccessMessage(__('Seller has been rejected successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error rejecting seller: %1', $e->getMessage()));
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}

