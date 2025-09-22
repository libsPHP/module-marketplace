<?php
/**
 * NativeMind Marketplace Helper
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package NativeMind\Marketplace\Helper
 */
class Data extends AbstractHelper
{
    const XML_PATH_ENABLED = 'marketplace/general/enabled';
    const XML_PATH_SELLER_REGISTRATION = 'marketplace/general/allow_seller_registration';
    const XML_PATH_REQUIRE_APPROVAL = 'marketplace/general/require_seller_approval';
    const XML_PATH_DEFAULT_COMMISSION = 'marketplace/general/default_commission_rate';
    const XML_PATH_ALLOW_SUBDOMAIN = 'marketplace/general/allow_subdomain';
    const XML_PATH_ALLOW_SUBDIRECTORY = 'marketplace/general/allow_subdirectory';
    
    const XML_PATH_AUTO_APPROVE = 'marketplace/seller/auto_approve';
    const XML_PATH_REQUIRE_DOCUMENT_VERIFICATION = 'marketplace/seller/require_document_verification';
    const XML_PATH_MIN_RATING = 'marketplace/seller/min_rating_for_approval';
    const XML_PATH_MAX_PRODUCTS = 'marketplace/seller/max_products_per_seller';
    
    const XML_PATH_PRODUCT_REQUIRE_APPROVAL = 'marketplace/product/require_approval';
    const XML_PATH_ALLOW_USED_PRODUCTS = 'marketplace/product/allow_used_products';
    const XML_PATH_MAX_IMAGES = 'marketplace/product/max_images_per_product';
    const XML_PATH_AUTO_APPROVE_PRODUCTS = 'marketplace/product/auto_approve_products';
    
    const XML_PATH_COMMISSION_DEFAULT = 'marketplace/commission/default_rate';
    const XML_PATH_COMMISSION_MIN = 'marketplace/commission/min_rate';
    const XML_PATH_COMMISSION_MAX = 'marketplace/commission/max_rate';
    const XML_PATH_COMMISSION_TAX_INCLUDED = 'marketplace/commission/tax_included';
    
    const XML_PATH_MESSAGING_ENABLED = 'marketplace/messaging/enabled';
    const XML_PATH_MESSAGING_ANONYMOUS = 'marketplace/messaging/allow_anonymous_messages';
    const XML_PATH_MESSAGING_MODERATE = 'marketplace/messaging/moderate_messages';
    
    const XML_PATH_RATING_ENABLED = 'marketplace/rating/enabled';
    const XML_PATH_RATING_REQUIRE_PURCHASE = 'marketplace/rating/require_purchase';
    const XML_PATH_RATING_ANONYMOUS = 'marketplace/rating/allow_anonymous_reviews';
    const XML_PATH_RATING_MODERATE = 'marketplace/rating/moderate_reviews';

    /**
     * {@inheritdoc}
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * Check if marketplace is enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if seller registration is allowed
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isSellerRegistrationAllowed(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_SELLER_REGISTRATION,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if seller approval is required
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isSellerApprovalRequired(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_REQUIRE_APPROVAL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get default commission rate
     *
     * @param int|null $storeId
     * @return float
     */
    public function getDefaultCommissionRate(?int $storeId = null): float
    {
        return (float) $this->scopeConfig->getValue(
            self::XML_PATH_DEFAULT_COMMISSION,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if subdomain is allowed
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isSubdomainAllowed(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ALLOW_SUBDOMAIN,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if subdirectory is allowed
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isSubdirectoryAllowed(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ALLOW_SUBDIRECTORY,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if auto approve is enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isAutoApproveEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_AUTO_APPROVE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if document verification is required
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isDocumentVerificationRequired(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_REQUIRE_DOCUMENT_VERIFICATION,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get minimum rating for approval
     *
     * @param int|null $storeId
     * @return float
     */
    public function getMinRatingForApproval(?int $storeId = null): float
    {
        return (float) $this->scopeConfig->getValue(
            self::XML_PATH_MIN_RATING,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get maximum products per seller
     *
     * @param int|null $storeId
     * @return int
     */
    public function getMaxProductsPerSeller(?int $storeId = null): int
    {
        return (int) $this->scopeConfig->getValue(
            self::XML_PATH_MAX_PRODUCTS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if product approval is required
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isProductApprovalRequired(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_PRODUCT_REQUIRE_APPROVAL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if used products are allowed
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isUsedProductsAllowed(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ALLOW_USED_PRODUCTS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get maximum images per product
     *
     * @param int|null $storeId
     * @return int
     */
    public function getMaxImagesPerProduct(?int $storeId = null): int
    {
        return (int) $this->scopeConfig->getValue(
            self::XML_PATH_MAX_IMAGES,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if auto approve products is enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isAutoApproveProductsEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_AUTO_APPROVE_PRODUCTS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get commission settings
     *
     * @param int|null $storeId
     * @return array
     */
    public function getCommissionSettings(?int $storeId = null): array
    {
        return [
            'default_rate' => $this->getDefaultCommissionRate($storeId),
            'min_rate' => (float) $this->scopeConfig->getValue(
                self::XML_PATH_COMMISSION_MIN,
                ScopeInterface::SCOPE_STORE,
                $storeId
            ),
            'max_rate' => (float) $this->scopeConfig->getValue(
                self::XML_PATH_COMMISSION_MAX,
                ScopeInterface::SCOPE_STORE,
                $storeId
            ),
            'tax_included' => $this->scopeConfig->isSetFlag(
                self::XML_PATH_COMMISSION_TAX_INCLUDED,
                ScopeInterface::SCOPE_STORE,
                $storeId
            )
        ];
    }

    /**
     * Check if messaging is enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isMessagingEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_MESSAGING_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if anonymous messages are allowed
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isAnonymousMessagesAllowed(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_MESSAGING_ANONYMOUS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if messages need moderation
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isMessageModerationRequired(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_MESSAGING_MODERATE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if rating system is enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isRatingEnabled(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_RATING_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if purchase is required for rating
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isPurchaseRequiredForRating(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_RATING_REQUIRE_PURCHASE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if anonymous reviews are allowed
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isAnonymousReviewsAllowed(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_RATING_ANONYMOUS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if reviews need moderation
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isReviewModerationRequired(?int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_RATING_MODERATE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get seller store URL
     *
     * @param string $subdomain
     * @param int|null $storeId
     * @return string
     */
    public function getSellerStoreUrl(string $subdomain, ?int $storeId = null): string
    {
        $baseUrl = $this->scopeConfig->getValue(
            'web/unsecure/base_url',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        if ($this->isSubdomainAllowed($storeId)) {
            return str_replace(['http://', 'https://'], ['http://' . $subdomain . '.', 'https://' . $subdomain . '.'], $baseUrl);
        } elseif ($this->isSubdirectoryAllowed($storeId)) {
            return rtrim($baseUrl, '/') . '/seller/' . $subdomain . '/';
        }

        return $baseUrl;
    }

    /**
     * Get marketplace configuration
     *
     * @param int|null $storeId
     * @return array
     */
    public function getMarketplaceConfig(?int $storeId = null): array
    {
        return [
            'enabled' => $this->isEnabled($storeId),
            'seller_registration' => $this->isSellerRegistrationAllowed($storeId),
            'seller_approval_required' => $this->isSellerApprovalRequired($storeId),
            'default_commission_rate' => $this->getDefaultCommissionRate($storeId),
            'subdomain_allowed' => $this->isSubdomainAllowed($storeId),
            'subdirectory_allowed' => $this->isSubdirectoryAllowed($storeId),
            'auto_approve' => $this->isAutoApproveEnabled($storeId),
            'document_verification_required' => $this->isDocumentVerificationRequired($storeId),
            'max_products_per_seller' => $this->getMaxProductsPerSeller($storeId),
            'product_approval_required' => $this->isProductApprovalRequired($storeId),
            'used_products_allowed' => $this->isUsedProductsAllowed($storeId),
            'max_images_per_product' => $this->getMaxImagesPerProduct($storeId),
            'auto_approve_products' => $this->isAutoApproveProductsEnabled($storeId),
            'commission_settings' => $this->getCommissionSettings($storeId),
            'messaging_enabled' => $this->isMessagingEnabled($storeId),
            'anonymous_messages_allowed' => $this->isAnonymousMessagesAllowed($storeId),
            'message_moderation_required' => $this->isMessageModerationRequired($storeId),
            'rating_enabled' => $this->isRatingEnabled($storeId),
            'purchase_required_for_rating' => $this->isPurchaseRequiredForRating($storeId),
            'anonymous_reviews_allowed' => $this->isAnonymousReviewsAllowed($storeId),
            'review_moderation_required' => $this->isReviewModerationRequired($storeId)
        ];
    }
}
