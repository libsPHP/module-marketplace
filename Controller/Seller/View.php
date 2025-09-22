<?php
/**
 * NativeMind Marketplace Seller View Controller
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Controller\Seller;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Exception\NotFoundException;
use NativeMind\Marketplace\Model\SubdomainHandler;

/**
 * Class View
 * @package NativeMind\Marketplace\Controller\Seller
 */
class View extends Action implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var SubdomainHandler
     */
    protected $subdomainHandler;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param SubdomainHandler $subdomainHandler
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        SubdomainHandler $subdomainHandler
    ) {
        $this->pageFactory = $pageFactory;
        $this->subdomainHandler = $subdomainHandler;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Framework\View\Result\Page
     * @throws NotFoundException
     */
    public function execute()
    {
        $seller = $this->subdomainHandler->getSellerFromRequest();
        
        if (!$seller) {
            throw new NotFoundException(__('Seller store not found.'));
        }

        if (!$seller->isActive() || !$seller->isApproved()) {
            throw new NotFoundException(__('Seller store is not available.'));
        }

        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->set($seller->getCompanyName() . ' - Marketplace Store');
        
        // Add meta description
        $page->getConfig()->setDescription('Shop at ' . $seller->getCompanyName() . ' marketplace store');
        
        // Add meta keywords
        $page->getConfig()->setKeywords($seller->getCompanyName() . ', marketplace, store, shop');

        // Register seller in registry for use in blocks
        $this->_objectManager->get(\Magento\Framework\Registry::class)
            ->register('current_seller', $seller);

        return $page;
    }
}
