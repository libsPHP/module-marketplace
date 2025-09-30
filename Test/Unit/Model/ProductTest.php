<?php
/**
 * NativeMind Marketplace Product Model Test
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use NativeMind\Marketplace\Model\Product;

/**
 * Class ProductTest
 * @package NativeMind\Marketplace\Test\Unit\Model
 */
class ProductTest extends TestCase
{
    /**
     * @var Product
     */
    protected $product;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->product = new Product();
    }

    /**
     * Test ID getter and setter
     */
    public function testId()
    {
        $id = 123;
        $this->product->setId($id);
        $this->assertEquals($id, $this->product->getId());
    }

    /**
     * Test seller ID getter and setter
     */
    public function testSellerId()
    {
        $sellerId = 456;
        $this->product->setSellerId($sellerId);
        $this->assertEquals($sellerId, $this->product->getSellerId());
    }

    /**
     * Test product ID getter and setter
     */
    public function testProductId()
    {
        $productId = 789;
        $this->product->setProductId($productId);
        $this->assertEquals($productId, $this->product->getProductId());
    }

    /**
     * Test condition getter and setter
     */
    public function testCondition()
    {
        $condition = Product::CONDITION_NEW;
        $this->product->setCondition($condition);
        $this->assertEquals($condition, $this->product->getCondition());
    }

    /**
     * Test is approved getter and setter
     */
    public function testIsApproved()
    {
        $isApproved = Product::APPROVED;
        $this->product->setIsApproved($isApproved);
        $this->assertEquals($isApproved, $this->product->getIsApproved());
    }

    /**
     * Test is approved method
     */
    public function testIsApprovedMethod()
    {
        $this->product->setIsApproved(Product::APPROVED);
        $this->assertTrue($this->product->isApproved());

        $this->product->setIsApproved(Product::NOT_APPROVED);
        $this->assertFalse($this->product->isApproved());
    }

    /**
     * Test is new method
     */
    public function testIsNew()
    {
        $this->product->setCondition(Product::CONDITION_NEW);
        $this->assertTrue($this->product->isNew());

        $this->product->setCondition(Product::CONDITION_USED);
        $this->assertFalse($this->product->isNew());
    }

    /**
     * Test is used method
     */
    public function testIsUsed()
    {
        $this->product->setCondition(Product::CONDITION_USED);
        $this->assertTrue($this->product->isUsed());

        $this->product->setCondition(Product::CONDITION_NEW);
        $this->assertFalse($this->product->isUsed());
    }

    /**
     * Test is refurbished method
     */
    public function testIsRefurbished()
    {
        $this->product->setCondition(Product::CONDITION_REFURBISHED);
        $this->assertTrue($this->product->isRefurbished());

        $this->product->setCondition(Product::CONDITION_NEW);
        $this->assertFalse($this->product->isRefurbished());
    }

    /**
     * Test is for parts method
     */
    public function testIsForParts()
    {
        $this->product->setCondition(Product::CONDITION_FOR_PARTS);
        $this->assertTrue($this->product->isForParts());

        $this->product->setCondition(Product::CONDITION_NEW);
        $this->assertFalse($this->product->isForParts());
    }

    /**
     * Test condition label method
     */
    public function testConditionLabel()
    {
        $this->product->setCondition(Product::CONDITION_NEW);
        $this->assertEquals('New', $this->product->getConditionLabel());

        $this->product->setCondition(Product::CONDITION_USED);
        $this->assertEquals('Used', $this->product->getConditionLabel());

        $this->product->setCondition(Product::CONDITION_REFURBISHED);
        $this->assertEquals('Refurbished', $this->product->getConditionLabel());

        $this->product->setCondition(Product::CONDITION_FOR_PARTS);
        $this->assertEquals('For Parts', $this->product->getConditionLabel());
    }

    /**
     * Test approval status label method
     */
    public function testApprovalStatusLabel()
    {
        $this->product->setIsApproved(Product::APPROVED);
        $this->assertEquals('Approved', $this->product->getApprovalStatusLabel());

        $this->product->setIsApproved(Product::NOT_APPROVED);
        $this->assertEquals('Pending', $this->product->getApprovalStatusLabel());
    }

    /**
     * Test get available conditions method
     */
    public function testGetAvailableConditions()
    {
        $conditions = Product::getAvailableConditions();
        
        $this->assertIsArray($conditions);
        $this->assertArrayHasKey(Product::CONDITION_NEW, $conditions);
        $this->assertArrayHasKey(Product::CONDITION_USED, $conditions);
        $this->assertArrayHasKey(Product::CONDITION_REFURBISHED, $conditions);
        $this->assertArrayHasKey(Product::CONDITION_FOR_PARTS, $conditions);
    }
}

