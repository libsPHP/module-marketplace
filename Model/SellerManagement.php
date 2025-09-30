<?php
/**
 * NativeMind Marketplace Seller Management
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use NativeMind\Marketplace\Api\Data\SellerInterface;
use NativeMind\Marketplace\Api\SellerManagementInterface;
use NativeMind\Marketplace\Api\SellerRepositoryInterface;
use NativeMind\Marketplace\Helper\Data as MarketplaceHelper;

/**
 * Class SellerManagement
 * @package NativeMind\Marketplace\Model
 */
class SellerManagement implements SellerManagementInterface
{
    /**
     * @var SellerRepositoryInterface
     */
    protected $sellerRepository;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var MarketplaceHelper
     */
    protected $marketplaceHelper;

    /**
     * Constructor
     *
     * @param SellerRepositoryInterface $sellerRepository
     * @param CustomerRepositoryInterface $customerRepository
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param MarketplaceHelper $marketplaceHelper
     */
    public function __construct(
        SellerRepositoryInterface $sellerRepository,
        CustomerRepositoryInterface $customerRepository,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        MarketplaceHelper $marketplaceHelper
    ) {
        $this->sellerRepository = $sellerRepository;
        $this->customerRepository = $customerRepository;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->marketplaceHelper = $marketplaceHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function register(array $sellerData): SellerInterface
    {
        if (!$this->marketplaceHelper->isEnabled()) {
            throw new LocalizedException(__('Marketplace is not enabled.'));
        }

        if (!$this->marketplaceHelper->isSellerRegistrationAllowed()) {
            throw new LocalizedException(__('Seller registration is not allowed.'));
        }

        $this->validateSellerData($sellerData);

        $customerId = $sellerData['customer_id'] ?? null;
        if (!$customerId) {
            throw new LocalizedException(__('Customer ID is required.'));
        }

        if (!$this->canRegister($customerId)) {
            throw new LocalizedException(__('Customer is already registered as seller or cannot register.'));
        }

        $customer = $this->customerRepository->getById($customerId);

        $seller = $this->sellerRepository->getById(0); // Create new seller
        $seller->setCustomerId($customerId);
        $seller->setCompanyName($sellerData['company_name']);
        $seller->setBusinessLicense($sellerData['business_license'] ?? '');
        $seller->setTaxId($sellerData['tax_id'] ?? '');
        $seller->setPhone($sellerData['phone'] ?? '');
        $seller->setAddress($sellerData['address'] ?? '');
        $seller->setCity($sellerData['city'] ?? '');
        $seller->setRegion($sellerData['region'] ?? '');
        $seller->setPostcode($sellerData['postcode'] ?? '');
        $seller->setCountryId($sellerData['country_id'] ?? '');
        
        // Generate subdomain
        $subdomain = $this->generateSubdomain($sellerData['company_name']);
        $seller->setSubdomain($subdomain);

        // Set default values
        $seller->setStatus(Seller::STATUS_ACTIVE);
        $seller->setApprovalStatus($this->marketplaceHelper->isAutoApproveEnabled() ? 
            Seller::APPROVAL_STATUS_APPROVED : Seller::APPROVAL_STATUS_PENDING);
        $seller->setCommissionRate($this->marketplaceHelper->getDefaultCommissionRate());

        $this->sellerRepository->save($seller);

        // Send notification email
        $this->sendNotification($seller->getSellerId(), 'registration', [
            'seller' => $seller,
            'customer' => $customer
        ]);

        return $seller;
    }

    /**
     * {@inheritdoc}
     */
    public function approve(int $sellerId): bool
    {
        $seller = $this->sellerRepository->getById($sellerId);
        $seller->setApprovalStatus(Seller::APPROVAL_STATUS_APPROVED);
        $this->sellerRepository->save($seller);

        $this->sendNotification($sellerId, 'approval', ['seller' => $seller]);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function suspend(int $sellerId, string $reason = ''): bool
    {
        $seller = $this->sellerRepository->getById($sellerId);
        $seller->setStatus(Seller::STATUS_SUSPENDED);
        $this->sellerRepository->save($seller);

        $this->sendNotification($sellerId, 'suspension', [
            'seller' => $seller,
            'reason' => $reason
        ]);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function reject(int $sellerId, string $reason = ''): bool
    {
        $seller = $this->sellerRepository->getById($sellerId);
        $seller->setApprovalStatus(Seller::APPROVAL_STATUS_REJECTED);
        $this->sellerRepository->save($seller);

        $this->sendNotification($sellerId, 'rejection', [
            'seller' => $seller,
            'reason' => $reason
        ]);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function activate(int $sellerId): bool
    {
        $seller = $this->sellerRepository->getById($sellerId);
        $seller->setStatus(Seller::STATUS_ACTIVE);
        $this->sellerRepository->save($seller);

        $this->sendNotification($sellerId, 'activation', ['seller' => $seller]);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deactivate(int $sellerId): bool
    {
        $seller = $this->sellerRepository->getById($sellerId);
        $seller->setStatus(Seller::STATUS_INACTIVE);
        $this->sellerRepository->save($seller);

        $this->sendNotification($sellerId, 'deactivation', ['seller' => $seller]);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function updateRating(int $sellerId): bool
    {
        $seller = $this->sellerRepository->getById($sellerId);
        $this->sellerRepository->save($seller);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function updateStatistics(int $sellerId): bool
    {
        $seller = $this->sellerRepository->getById($sellerId);
        $this->sellerRepository->save($seller);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function canRegister(int $customerId): bool
    {
        try {
            $this->sellerRepository->getByCustomerId($customerId);
            return false; // Already registered
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return true; // Not registered yet
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateSellerData(array $sellerData): bool
    {
        $requiredFields = ['company_name', 'customer_id'];
        
        foreach ($requiredFields as $field) {
            if (empty($sellerData[$field])) {
                throw new LocalizedException(__('Field "%1" is required.', $field));
            }
        }

        // Validate company name
        if (strlen($sellerData['company_name']) < 2) {
            throw new LocalizedException(__('Company name must be at least 2 characters long.'));
        }

        // Validate subdomain if provided
        if (isset($sellerData['subdomain']) && !empty($sellerData['subdomain'])) {
            if (!$this->isSubdomainAvailable($sellerData['subdomain'])) {
                throw new LocalizedException(__('Subdomain "%1" is already taken.', $sellerData['subdomain']));
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function generateSubdomain(string $companyName): string
    {
        $subdomain = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $companyName));
        $subdomain = substr($subdomain, 0, 20); // Limit length
        
        $originalSubdomain = $subdomain;
        $counter = 1;
        
        while (!$this->isSubdomainAvailable($subdomain)) {
            $subdomain = $originalSubdomain . $counter;
            $counter++;
        }
        
        return $subdomain;
    }

    /**
     * {@inheritdoc}
     */
    public function isSubdomainAvailable(string $subdomain): bool
    {
        try {
            $this->sellerRepository->getBySubdomain($subdomain);
            return false;
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDashboardData(int $sellerId): array
    {
        $seller = $this->sellerRepository->getById($sellerId);
        
        return [
            'seller' => $seller,
            'statistics' => [
                'product_count' => $seller->getProductCount(),
                'review_count' => $seller->getReviewCount(),
                'rating' => $seller->getRating(),
                'total_sales' => $seller->getTotalSales()
            ],
            'recent_orders' => [], // TODO: Implement
            'recent_reviews' => [], // TODO: Implement
            'recent_messages' => [] // TODO: Implement
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function sendNotification(int $sellerId, string $type, array $data = []): bool
    {
        try {
            $seller = $this->sellerRepository->getById($sellerId);
            $customer = $this->customerRepository->getById($seller->getCustomerId());
            
            $store = $this->storeManager->getStore();
            
            $templateVars = array_merge([
                'seller' => $seller,
                'customer' => $customer,
                'store' => $store
            ], $data);

            $this->inlineTranslation->suspend();
            
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('marketplace_seller_' . $type)
                ->setTemplateOptions([
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $store->getId()
                ])
                ->setTemplateVars($templateVars)
                ->setFromByScope('general', $store->getId())
                ->addTo($customer->getEmail(), $customer->getFirstname() . ' ' . $customer->getLastname())
                ->getTransport();

            $transport->sendMessage();
            $this->inlineTranslation->resume();
            
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

