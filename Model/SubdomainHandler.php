<?php
/**
 * NativeMind Marketplace Subdomain Handler
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Model;

use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreManagerInterface;
use NativeMind\Marketplace\Api\SellerRepositoryInterface;
use NativeMind\Marketplace\Helper\Data as MarketplaceHelper;

/**
 * Class SubdomainHandler
 * @package NativeMind\Marketplace\Model
 */
class SubdomainHandler
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var SellerRepositoryInterface
     */
    protected $sellerRepository;

    /**
     * @var MarketplaceHelper
     */
    protected $marketplaceHelper;

    /**
     * Constructor
     *
     * @param RequestInterface $request
     * @param StoreManagerInterface $storeManager
     * @param SellerRepositoryInterface $sellerRepository
     * @param MarketplaceHelper $marketplaceHelper
     */
    public function __construct(
        RequestInterface $request,
        StoreManagerInterface $storeManager,
        SellerRepositoryInterface $sellerRepository,
        MarketplaceHelper $marketplaceHelper
    ) {
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->sellerRepository = $sellerRepository;
        $this->marketplaceHelper = $marketplaceHelper;
    }

    /**
     * Get seller from current request
     *
     * @return \NativeMind\Marketplace\Api\Data\SellerInterface|null
     */
    public function getSellerFromRequest(): ?\NativeMind\Marketplace\Api\Data\SellerInterface
    {
        $subdomain = $this->getSubdomainFromRequest();
        if (!$subdomain) {
            return null;
        }

        try {
            return $this->sellerRepository->getBySubdomain($subdomain);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * Get subdomain from current request
     *
     * @return string|null
     */
    public function getSubdomainFromRequest(): ?string
    {
        $host = $this->request->getHttpHost();
        $path = $this->request->getPathInfo();

        // Check for subdomain
        if ($this->marketplaceHelper->isSubdomainAllowed()) {
            $subdomain = $this->extractSubdomainFromHost($host);
            if ($subdomain) {
                return $subdomain;
            }
        }

        // Check for subdirectory
        if ($this->marketplaceHelper->isSubdirectoryAllowed()) {
            return $this->extractSubdomainFromPath($path);
        }

        return null;
    }

    /**
     * Extract subdomain from host
     *
     * @param string $host
     * @return string|null
     */
    protected function extractSubdomainFromHost(string $host): ?string
    {
        $parts = explode('.', $host);
        
        // Must have at least 3 parts for subdomain (subdomain.domain.com)
        if (count($parts) < 3) {
            return null;
        }

        $subdomain = $parts[0];
        
        // Validate subdomain format
        if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]$/', $subdomain)) {
            return null;
        }

        return $subdomain;
    }

    /**
     * Extract subdomain from path
     *
     * @param string $path
     * @return string|null
     */
    protected function extractSubdomainFromPath(string $path): ?string
    {
        // Match pattern: /seller/sellername/
        if (preg_match('/^\/seller\/([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9])\//', $path, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Get seller store URL
     *
     * @param string $subdomain
     * @return string
     */
    public function getSellerStoreUrl(string $subdomain): string
    {
        return $this->marketplaceHelper->getSellerStoreUrl($subdomain);
    }

    /**
     * Check if current request is for seller store
     *
     * @return bool
     */
    public function isSellerStoreRequest(): bool
    {
        return $this->getSellerFromRequest() !== null;
    }

    /**
     * Get seller store configuration
     *
     * @param string $subdomain
     * @return array
     */
    public function getSellerStoreConfig(string $subdomain): array
    {
        try {
            $seller = $this->sellerRepository->getBySubdomain($subdomain);
            
            return [
                'seller' => $seller,
                'store_url' => $this->getSellerStoreUrl($subdomain),
                'is_active' => $seller->isActive(),
                'is_approved' => $seller->isApproved(),
                'company_name' => $seller->getCompanyName(),
                'rating' => $seller->getRating(),
                'review_count' => $seller->getReviewCount(),
                'product_count' => $seller->getProductCount()
            ];
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return [];
        }
    }

    /**
     * Validate subdomain format
     *
     * @param string $subdomain
     * @return bool
     */
    public function validateSubdomainFormat(string $subdomain): bool
    {
        // Check length
        if (strlen($subdomain) < 2 || strlen($subdomain) > 50) {
            return false;
        }

        // Check format
        if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]$/', $subdomain)) {
            return false;
        }

        // Check for reserved words
        $reservedWords = [
            'www', 'admin', 'api', 'app', 'blog', 'shop', 'store', 'marketplace',
            'seller', 'buyer', 'customer', 'user', 'account', 'profile', 'dashboard'
        ];

        if (in_array(strtolower($subdomain), $reservedWords)) {
            return false;
        }

        return true;
    }

    /**
     * Generate unique subdomain
     *
     * @param string $companyName
     * @return string
     */
    public function generateUniqueSubdomain(string $companyName): string
    {
        $baseSubdomain = $this->sanitizeSubdomain($companyName);
        $subdomain = $baseSubdomain;
        $counter = 1;

        while (!$this->isSubdomainAvailable($subdomain)) {
            $subdomain = $baseSubdomain . $counter;
            $counter++;
        }

        return $subdomain;
    }

    /**
     * Sanitize subdomain from company name
     *
     * @param string $companyName
     * @return string
     */
    protected function sanitizeSubdomain(string $companyName): string
    {
        // Convert to lowercase
        $subdomain = strtolower($companyName);
        
        // Remove special characters
        $subdomain = preg_replace('/[^a-zA-Z0-9-]/', '', $subdomain);
        
        // Remove multiple hyphens
        $subdomain = preg_replace('/-+/', '-', $subdomain);
        
        // Remove leading/trailing hyphens
        $subdomain = trim($subdomain, '-');
        
        // Limit length
        $subdomain = substr($subdomain, 0, 30);
        
        return $subdomain;
    }

    /**
     * Check if subdomain is available
     *
     * @param string $subdomain
     * @return bool
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
     * Get seller store theme
     *
     * @param string $subdomain
     * @return string|null
     */
    public function getSellerStoreTheme(string $subdomain): ?string
    {
        // This would be implemented to get custom theme for seller
        // For now, return default theme
        return null;
    }

    /**
     * Get seller store logo
     *
     * @param string $subdomain
     * @return string|null
     */
    public function getSellerStoreLogo(string $subdomain): ?string
    {
        // This would be implemented to get custom logo for seller
        // For now, return null
        return null;
    }

    /**
     * Get seller store banner
     *
     * @param string $subdomain
     * @return string|null
     */
    public function getSellerStoreBanner(string $subdomain): ?string
    {
        // This would be implemented to get custom banner for seller
        // For now, return null
        return null;
    }

    /**
     * Get seller store description
     *
     * @param string $subdomain
     * @return string|null
     */
    public function getSellerStoreDescription(string $subdomain): ?string
    {
        // This would be implemented to get custom description for seller
        // For now, return null
        return null;
    }

    /**
     * Get seller store meta data
     *
     * @param string $subdomain
     * @return array
     */
    public function getSellerStoreMetaData(string $subdomain): array
    {
        try {
            $seller = $this->sellerRepository->getBySubdomain($subdomain);
            
            return [
                'title' => $seller->getCompanyName() . ' - Marketplace Store',
                'description' => 'Shop at ' . $seller->getCompanyName() . ' marketplace store',
                'keywords' => $seller->getCompanyName() . ', marketplace, store, shop',
                'robots' => 'index,follow'
            ];
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return [
                'title' => 'Store Not Found',
                'description' => 'The requested store could not be found',
                'keywords' => '',
                'robots' => 'noindex,nofollow'
            ];
        }
    }
}
