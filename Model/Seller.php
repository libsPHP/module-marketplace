<?php
/**
 * NativeMind Marketplace Seller Model
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Model;

use Magento\Framework\Model\AbstractModel;
use NativeMind\Marketplace\Api\Data\SellerInterface;

/**
 * Class Seller
 * @package NativeMind\Marketplace\Model
 */
class Seller extends AbstractModel implements SellerInterface
{
    /**
     * Status constants
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_SUSPENDED = 2;

    /**
     * Approval status constants
     */
    const APPROVAL_STATUS_PENDING = 0;
    const APPROVAL_STATUS_APPROVED = 1;
    const APPROVAL_STATUS_REJECTED = 2;

    /**
     * @var string
     */
    protected $_eventPrefix = 'native_marketplace_seller';

    /**
     * @var string
     */
    protected $_eventObject = 'seller';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\NativeMind\Marketplace\Model\ResourceModel\Seller::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerId(): ?int
    {
        return $this->getData(self::SELLER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setSellerId(int $sellerId): SellerInterface
    {
        return $this->setData(self::SELLER_ID, $sellerId);
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerId(): ?int
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setCustomerId(int $customerId): SellerInterface
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * {@inheritdoc}
     */
    public function getCompanyName(): ?string
    {
        return $this->getData(self::COMPANY_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function setCompanyName(string $companyName): SellerInterface
    {
        return $this->setData(self::COMPANY_NAME, $companyName);
    }

    /**
     * {@inheritdoc}
     */
    public function getBusinessLicense(): ?string
    {
        return $this->getData(self::BUSINESS_LICENSE);
    }

    /**
     * {@inheritdoc}
     */
    public function setBusinessLicense(string $businessLicense): SellerInterface
    {
        return $this->setData(self::BUSINESS_LICENSE, $businessLicense);
    }

    /**
     * {@inheritdoc}
     */
    public function getTaxId(): ?string
    {
        return $this->getData(self::TAX_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setTaxId(string $taxId): SellerInterface
    {
        return $this->setData(self::TAX_ID, $taxId);
    }

    /**
     * {@inheritdoc}
     */
    public function getPhone(): ?string
    {
        return $this->getData(self::PHONE);
    }

    /**
     * {@inheritdoc}
     */
    public function setPhone(string $phone): SellerInterface
    {
        return $this->setData(self::PHONE, $phone);
    }

    /**
     * {@inheritdoc}
     */
    public function getAddress(): ?string
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     * {@inheritdoc}
     */
    public function setAddress(string $address): SellerInterface
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * {@inheritdoc}
     */
    public function getCity(): ?string
    {
        return $this->getData(self::CITY);
    }

    /**
     * {@inheritdoc}
     */
    public function setCity(string $city): SellerInterface
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * {@inheritdoc}
     */
    public function getRegion(): ?string
    {
        return $this->getData(self::REGION);
    }

    /**
     * {@inheritdoc}
     */
    public function setRegion(string $region): SellerInterface
    {
        return $this->setData(self::REGION, $region);
    }

    /**
     * {@inheritdoc}
     */
    public function getPostcode(): ?string
    {
        return $this->getData(self::POSTCODE);
    }

    /**
     * {@inheritdoc}
     */
    public function setPostcode(string $postcode): SellerInterface
    {
        return $this->setData(self::POSTCODE, $postcode);
    }

    /**
     * {@inheritdoc}
     */
    public function getCountryId(): ?string
    {
        return $this->getData(self::COUNTRY_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setCountryId(string $countryId): SellerInterface
    {
        return $this->setData(self::COUNTRY_ID, $countryId);
    }

    /**
     * {@inheritdoc}
     */
    public function getSubdomain(): ?string
    {
        return $this->getData(self::SUBDOMAIN);
    }

    /**
     * {@inheritdoc}
     */
    public function setSubdomain(string $subdomain): SellerInterface
    {
        return $this->setData(self::SUBDOMAIN, $subdomain);
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus(): ?int
    {
        return $this->getData(self::STATUS);
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus(int $status): SellerInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * {@inheritdoc}
     */
    public function getApprovalStatus(): ?int
    {
        return $this->getData(self::APPROVAL_STATUS);
    }

    /**
     * {@inheritdoc}
     */
    public function setApprovalStatus(int $approvalStatus): SellerInterface
    {
        return $this->setData(self::APPROVAL_STATUS, $approvalStatus);
    }

    /**
     * {@inheritdoc}
     */
    public function getCommissionRate(): ?float
    {
        return $this->getData(self::COMMISSION_RATE);
    }

    /**
     * {@inheritdoc}
     */
    public function setCommissionRate(float $commissionRate): SellerInterface
    {
        return $this->setData(self::COMMISSION_RATE, $commissionRate);
    }

    /**
     * {@inheritdoc}
     */
    public function getRating(): ?float
    {
        return $this->getData(self::RATING);
    }

    /**
     * {@inheritdoc}
     */
    public function setRating(float $rating): SellerInterface
    {
        return $this->setData(self::RATING, $rating);
    }

    /**
     * {@inheritdoc}
     */
    public function getReviewCount(): ?int
    {
        return $this->getData(self::REVIEW_COUNT);
    }

    /**
     * {@inheritdoc}
     */
    public function setReviewCount(int $reviewCount): SellerInterface
    {
        return $this->setData(self::REVIEW_COUNT, $reviewCount);
    }

    /**
     * {@inheritdoc}
     */
    public function getProductCount(): ?int
    {
        return $this->getData(self::PRODUCT_COUNT);
    }

    /**
     * {@inheritdoc}
     */
    public function setProductCount(int $productCount): SellerInterface
    {
        return $this->setData(self::PRODUCT_COUNT, $productCount);
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalSales(): ?float
    {
        return $this->getData(self::TOTAL_SALES);
    }

    /**
     * {@inheritdoc}
     */
    public function setTotalSales(float $totalSales): SellerInterface
    {
        return $this->setData(self::TOTAL_SALES, $totalSales);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(string $createdAt): SellerInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(string $updatedAt): SellerInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Check if seller is active
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->getStatus() == self::STATUS_ACTIVE;
    }

    /**
     * Check if seller is approved
     *
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->getApprovalStatus() == self::APPROVAL_STATUS_APPROVED;
    }

    /**
     * Check if seller is pending
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->getApprovalStatus() == self::APPROVAL_STATUS_PENDING;
    }

    /**
     * Check if seller is rejected
     *
     * @return bool
     */
    public function isRejected(): bool
    {
        return $this->getApprovalStatus() == self::APPROVAL_STATUS_REJECTED;
    }

    /**
     * Check if seller is suspended
     *
     * @return bool
     */
    public function isSuspended(): bool
    {
        return $this->getStatus() == self::STATUS_SUSPENDED;
    }

    /**
     * Get seller status label
     *
     * @return string
     */
    public function getStatusLabel(): string
    {
        $statusLabels = [
            self::STATUS_INACTIVE => __('Inactive'),
            self::STATUS_ACTIVE => __('Active'),
            self::STATUS_SUSPENDED => __('Suspended')
        ];

        return $statusLabels[$this->getStatus()] ?? __('Unknown');
    }

    /**
     * Get approval status label
     *
     * @return string
     */
    public function getApprovalStatusLabel(): string
    {
        $approvalLabels = [
            self::APPROVAL_STATUS_PENDING => __('Pending'),
            self::APPROVAL_STATUS_APPROVED => __('Approved'),
            self::APPROVAL_STATUS_REJECTED => __('Rejected')
        ];

        return $approvalLabels[$this->getApprovalStatus()] ?? __('Unknown');
    }
}
