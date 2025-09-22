<?php
/**
 * NativeMind Marketplace Admin Seller Approve Controller
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
 * Class Approve
 * @package NativeMind\Marketplace\Controller\Adminhtml\Seller
 */
class Approve extends Action
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
        
        if (!$sellerId) {
            $this->messageManager->addErrorMessage(__('Seller ID is required.'));
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        try {
            $this->sellerManagement->approve($sellerId);
            $this->messageManager->addSuccessMessage(__('Seller has been approved successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error approving seller: %1', $e->getMessage()));
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}
