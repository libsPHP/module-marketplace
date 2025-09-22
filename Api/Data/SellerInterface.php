<?php
/**
 * NativeMind Marketplace Seller Data Interface
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Api\Data;

/**
 * Interface SellerInterface
 * @package NativeMind\Marketplace\Api\Data
 */
interface SellerInterface
{
    const SELLER_ID = 'seller_id';
    const CUSTOMER_ID = 'customer_id';
    const COMPANY_NAME = 'company_name';
    const BUSINESS_LICENSE = 'business_license';
    const TAX_ID = 'tax_id';
    const PHONE = 'phone';
    const ADDRESS = 'address';
    const CITY = 'city';
    const REGION = 'region';
    const POSTCODE = 'postcode';
    const COUNTRY_ID = 'country_id';
    const SUBDOMAIN = 'subdomain';
    const STATUS = 'status';
    const APPROVAL_STATUS = 'approval_status';
    const COMMISSION_RATE = 'commission_rate';
    const RATING = 'rating';
    const REVIEW_COUNT = 'review_count';
    const PRODUCT_COUNT = 'product_count';
    const TOTAL_SALES = 'total_sales';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Get seller ID
     *
     * @return int|null
     */
    public function getSellerId(): ?int;

    /**
     * Set seller ID
     *
     * @param int $sellerId
     * @return SellerInterface
     */
    public function setSellerId(int $sellerId): SellerInterface;

    /**
     * Get customer ID
     *
     * @return int|null
     */
    public function getCustomerId(): ?int;

    /**
     * Set customer ID
     *
     * @param int $customerId
     * @return SellerInterface
     */
    public function setCustomerId(int $customerId): SellerInterface;

    /**
     * Get company name
     *
     * @return string|null
     */
    public function getCompanyName(): ?string;

    /**
     * Set company name
     *
     * @param string $companyName
     * @return SellerInterface
     */
    public function setCompanyName(string $companyName): SellerInterface;

    /**
     * Get business license
     *
     * @return string|null
     */
    public function getBusinessLicense(): ?string;

    /**
     * Set business license
     *
     * @param string $businessLicense
     * @return SellerInterface
     */
    public function setBusinessLicense(string $businessLicense): SellerInterface;

    /**
     * Get tax ID
     *
     * @return string|null
     */
    public function getTaxId(): ?string;

    /**
     * Set tax ID
     *
     * @param string $taxId
     * @return SellerInterface
     */
    public function setTaxId(string $taxId): SellerInterface;

    /**
     * Get phone
     *
     * @return string|null
     */
    public function getPhone(): ?string;

    /**
     * Set phone
     *
     * @param string $phone
     * @return SellerInterface
     */
    public function setPhone(string $phone): SellerInterface;

    /**
     * Get address
     *
     * @return string|null
     */
    public function getAddress(): ?string;

    /**
     * Set address
     *
     * @param string $address
     * @return SellerInterface
     */
    public function setAddress(string $address): SellerInterface;

    /**
     * Get city
     *
     * @return string|null
     */
    public function getCity(): ?string;

    /**
     * Set city
     *
     * @param string $city
     * @return SellerInterface
     */
    public function setCity(string $city): SellerInterface;

    /**
     * Get region
     *
     * @return string|null
     */
    public function getRegion(): ?string;

    /**
     * Set region
     *
     * @param string $region
     * @return SellerInterface
     */
    public function setRegion(string $region): SellerInterface;

    /**
     * Get postcode
     *
     * @return string|null
     */
    public function getPostcode(): ?string;

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return SellerInterface
     */
    public function setPostcode(string $postcode): SellerInterface;

    /**
     * Get country ID
     *
     * @return string|null
     */
    public function getCountryId(): ?string;

    /**
     * Set country ID
     *
     * @param string $countryId
     * @return SellerInterface
     */
    public function setCountryId(string $countryId): SellerInterface;

    /**
     * Get subdomain
     *
     * @return string|null
     */
    public function getSubdomain(): ?string;

    /**
     * Set subdomain
     *
     * @param string $subdomain
     * @return SellerInterface
     */
    public function setSubdomain(string $subdomain): SellerInterface;

    /**
     * Get status
     *
     * @return int|null
     */
    public function getStatus(): ?int;

    /**
     * Set status
     *
     * @param int $status
     * @return SellerInterface
     */
    public function setStatus(int $status): SellerInterface;

    /**
     * Get approval status
     *
     * @return int|null
     */
    public function getApprovalStatus(): ?int;

    /**
     * Set approval status
     *
     * @param int $approvalStatus
     * @return SellerInterface
     */
    public function setApprovalStatus(int $approvalStatus): SellerInterface;

    /**
     * Get commission rate
     *
     * @return float|null
     */
    public function getCommissionRate(): ?float;

    /**
     * Set commission rate
     *
     * @param float $commissionRate
     * @return SellerInterface
     */
    public function setCommissionRate(float $commissionRate): SellerInterface;

    /**
     * Get rating
     *
     * @return float|null
     */
    public function getRating(): ?float;

    /**
     * Set rating
     *
     * @param float $rating
     * @return SellerInterface
     */
    public function setRating(float $rating): SellerInterface;

    /**
     * Get review count
     *
     * @return int|null
     */
    public function getReviewCount(): ?int;

    /**
     * Set review count
     *
     * @param int $reviewCount
     * @return SellerInterface
     */
    public function setReviewCount(int $reviewCount): SellerInterface;

    /**
     * Get product count
     *
     * @return int|null
     */
    public function getProductCount(): ?int;

    /**
     * Set product count
     *
     * @param int $productCount
     * @return SellerInterface
     */
    public function setProductCount(int $productCount): SellerInterface;

    /**
     * Get total sales
     *
     * @return float|null
     */
    public function getTotalSales(): ?float;

    /**
     * Set total sales
     *
     * @param float $totalSales
     * @return SellerInterface
     */
    public function setTotalSales(float $totalSales): SellerInterface;

    /**
     * Get created at
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * Set created at
     *
     * @param string $createdAt
     * @return SellerInterface
     */
    public function setCreatedAt(string $createdAt): SellerInterface;

    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Set updated at
     *
     * @param string $updatedAt
     * @return SellerInterface
     */
    public function setUpdatedAt(string $updatedAt): SellerInterface;
}
