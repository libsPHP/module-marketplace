<?php
/**
 * NativeMind Marketplace Seller Model Test
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use NativeMind\Marketplace\Model\Seller;

/**
 * Class SellerTest
 * @package NativeMind\Marketplace\Test\Unit\Model
 */
class SellerTest extends TestCase
{
    /**
     * @var Seller
     */
    protected $seller;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->seller = new Seller();
    }

    /**
     * Test seller ID getter and setter
     */
    public function testSellerId()
    {
        $sellerId = 123;
        $this->seller->setSellerId($sellerId);
        $this->assertEquals($sellerId, $this->seller->getSellerId());
    }

    /**
     * Test customer ID getter and setter
     */
    public function testCustomerId()
    {
        $customerId = 456;
        $this->seller->setCustomerId($customerId);
        $this->assertEquals($customerId, $this->seller->getCustomerId());
    }

    /**
     * Test company name getter and setter
     */
    public function testCompanyName()
    {
        $companyName = 'Test Company';
        $this->seller->setCompanyName($companyName);
        $this->assertEquals($companyName, $this->seller->getCompanyName());
    }

    /**
     * Test subdomain getter and setter
     */
    public function testSubdomain()
    {
        $subdomain = 'testcompany';
        $this->seller->setSubdomain($subdomain);
        $this->assertEquals($subdomain, $this->seller->getSubdomain());
    }

    /**
     * Test status getter and setter
     */
    public function testStatus()
    {
        $status = Seller::STATUS_ACTIVE;
        $this->seller->setStatus($status);
        $this->assertEquals($status, $this->seller->getStatus());
    }

    /**
     * Test approval status getter and setter
     */
    public function testApprovalStatus()
    {
        $approvalStatus = Seller::APPROVAL_STATUS_APPROVED;
        $this->seller->setApprovalStatus($approvalStatus);
        $this->assertEquals($approvalStatus, $this->seller->getApprovalStatus());
    }

    /**
     * Test commission rate getter and setter
     */
    public function testCommissionRate()
    {
        $commissionRate = 5.5;
        $this->seller->setCommissionRate($commissionRate);
        $this->assertEquals($commissionRate, $this->seller->getCommissionRate());
    }

    /**
     * Test rating getter and setter
     */
    public function testRating()
    {
        $rating = 4.5;
        $this->seller->setRating($rating);
        $this->assertEquals($rating, $this->seller->getRating());
    }

    /**
     * Test review count getter and setter
     */
    public function testReviewCount()
    {
        $reviewCount = 25;
        $this->seller->setReviewCount($reviewCount);
        $this->assertEquals($reviewCount, $this->seller->getReviewCount());
    }

    /**
     * Test product count getter and setter
     */
    public function testProductCount()
    {
        $productCount = 100;
        $this->seller->setProductCount($productCount);
        $this->assertEquals($productCount, $this->seller->getProductCount());
    }

    /**
     * Test total sales getter and setter
     */
    public function testTotalSales()
    {
        $totalSales = 10000.50;
        $this->seller->setTotalSales($totalSales);
        $this->assertEquals($totalSales, $this->seller->getTotalSales());
    }

    /**
     * Test is active method
     */
    public function testIsActive()
    {
        $this->seller->setStatus(Seller::STATUS_ACTIVE);
        $this->assertTrue($this->seller->isActive());

        $this->seller->setStatus(Seller::STATUS_INACTIVE);
        $this->assertFalse($this->seller->isActive());
    }

    /**
     * Test is approved method
     */
    public function testIsApproved()
    {
        $this->seller->setApprovalStatus(Seller::APPROVAL_STATUS_APPROVED);
        $this->assertTrue($this->seller->isApproved());

        $this->seller->setApprovalStatus(Seller::APPROVAL_STATUS_PENDING);
        $this->assertFalse($this->seller->isApproved());
    }

    /**
     * Test is pending method
     */
    public function testIsPending()
    {
        $this->seller->setApprovalStatus(Seller::APPROVAL_STATUS_PENDING);
        $this->assertTrue($this->seller->isPending());

        $this->seller->setApprovalStatus(Seller::APPROVAL_STATUS_APPROVED);
        $this->assertFalse($this->seller->isPending());
    }

    /**
     * Test is rejected method
     */
    public function testIsRejected()
    {
        $this->seller->setApprovalStatus(Seller::APPROVAL_STATUS_REJECTED);
        $this->assertTrue($this->seller->isRejected());

        $this->seller->setApprovalStatus(Seller::APPROVAL_STATUS_APPROVED);
        $this->assertFalse($this->seller->isRejected());
    }

    /**
     * Test is suspended method
     */
    public function testIsSuspended()
    {
        $this->seller->setStatus(Seller::STATUS_SUSPENDED);
        $this->assertTrue($this->seller->isSuspended());

        $this->seller->setStatus(Seller::STATUS_ACTIVE);
        $this->assertFalse($this->seller->isSuspended());
    }

    /**
     * Test status label method
     */
    public function testStatusLabel()
    {
        $this->seller->setStatus(Seller::STATUS_ACTIVE);
        $this->assertEquals('Active', $this->seller->getStatusLabel());

        $this->seller->setStatus(Seller::STATUS_INACTIVE);
        $this->assertEquals('Inactive', $this->seller->getStatusLabel());

        $this->seller->setStatus(Seller::STATUS_SUSPENDED);
        $this->assertEquals('Suspended', $this->seller->getStatusLabel());
    }

    /**
     * Test approval status label method
     */
    public function testApprovalStatusLabel()
    {
        $this->seller->setApprovalStatus(Seller::APPROVAL_STATUS_APPROVED);
        $this->assertEquals('Approved', $this->seller->getApprovalStatusLabel());

        $this->seller->setApprovalStatus(Seller::APPROVAL_STATUS_PENDING);
        $this->assertEquals('Pending', $this->seller->getApprovalStatusLabel());

        $this->seller->setApprovalStatus(Seller::APPROVAL_STATUS_REJECTED);
        $this->assertEquals('Rejected', $this->seller->getApprovalStatusLabel());
    }
}
