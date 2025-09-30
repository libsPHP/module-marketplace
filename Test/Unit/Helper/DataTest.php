<?php
/**
 * NativeMind Marketplace Helper Data Test
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Test\Unit\Helper;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use NativeMind\Marketplace\Helper\Data;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class DataTest
 * @package NativeMind\Marketplace\Test\Unit\Helper
 */
class DataTest extends TestCase
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var MockObject|ScopeConfigInterface
     */
    protected $scopeConfigMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->scopeConfigMock = $this->createMock(ScopeConfigInterface::class);
        $this->helper = new Data(
            $this->createMock(\Magento\Framework\App\Helper\Context::class)
        );
    }

    /**
     * Test is enabled method
     */
    public function testIsEnabled()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isEnabled());
    }

    /**
     * Test is seller registration allowed method
     */
    public function testIsSellerRegistrationAllowed()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_SELLER_REGISTRATION, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isSellerRegistrationAllowed());
    }

    /**
     * Test is seller approval required method
     */
    public function testIsSellerApprovalRequired()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_REQUIRE_APPROVAL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isSellerApprovalRequired());
    }

    /**
     * Test get default commission rate method
     */
    public function testGetDefaultCommissionRate()
    {
        $rate = 5.0;
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(Data::XML_PATH_DEFAULT_COMMISSION, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn($rate);

        $this->assertEquals($rate, $this->helper->getDefaultCommissionRate());
    }

    /**
     * Test is subdomain allowed method
     */
    public function testIsSubdomainAllowed()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_ALLOW_SUBDOMAIN, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isSubdomainAllowed());
    }

    /**
     * Test is subdirectory allowed method
     */
    public function testIsSubdirectoryAllowed()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_ALLOW_SUBDIRECTORY, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isSubdirectoryAllowed());
    }

    /**
     * Test is auto approve enabled method
     */
    public function testIsAutoApproveEnabled()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_AUTO_APPROVE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isAutoApproveEnabled());
    }

    /**
     * Test is document verification required method
     */
    public function testIsDocumentVerificationRequired()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_REQUIRE_DOCUMENT_VERIFICATION, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isDocumentVerificationRequired());
    }

    /**
     * Test get min rating for approval method
     */
    public function testGetMinRatingForApproval()
    {
        $rating = 3.0;
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(Data::XML_PATH_MIN_RATING, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn($rating);

        $this->assertEquals($rating, $this->helper->getMinRatingForApproval());
    }

    /**
     * Test get max products per seller method
     */
    public function testGetMaxProductsPerSeller()
    {
        $maxProducts = 1000;
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(Data::XML_PATH_MAX_PRODUCTS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn($maxProducts);

        $this->assertEquals($maxProducts, $this->helper->getMaxProductsPerSeller());
    }

    /**
     * Test is product approval required method
     */
    public function testIsProductApprovalRequired()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_PRODUCT_REQUIRE_APPROVAL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isProductApprovalRequired());
    }

    /**
     * Test is used products allowed method
     */
    public function testIsUsedProductsAllowed()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_ALLOW_USED_PRODUCTS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isUsedProductsAllowed());
    }

    /**
     * Test get max images per product method
     */
    public function testGetMaxImagesPerProduct()
    {
        $maxImages = 10;
        $this->scopeConfigMock->expects($this->once())
            ->method('getValue')
            ->with(Data::XML_PATH_MAX_IMAGES, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn($maxImages);

        $this->assertEquals($maxImages, $this->helper->getMaxImagesPerProduct());
    }

    /**
     * Test is auto approve products enabled method
     */
    public function testIsAutoApproveProductsEnabled()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_AUTO_APPROVE_PRODUCTS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isAutoApproveProductsEnabled());
    }

    /**
     * Test get commission settings method
     */
    public function testGetCommissionSettings()
    {
        $this->scopeConfigMock->expects($this->exactly(4))
            ->method('getValue')
            ->willReturnMap([
                [Data::XML_PATH_DEFAULT_COMMISSION, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null, 5.0],
                [Data::XML_PATH_COMMISSION_MIN, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null, 1.0],
                [Data::XML_PATH_COMMISSION_MAX, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null, 20.0],
                [Data::XML_PATH_COMMISSION_TAX_INCLUDED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null, true]
            ]);

        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_COMMISSION_TAX_INCLUDED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $settings = $this->helper->getCommissionSettings();
        
        $this->assertIsArray($settings);
        $this->assertEquals(5.0, $settings['default_rate']);
        $this->assertEquals(1.0, $settings['min_rate']);
        $this->assertEquals(20.0, $settings['max_rate']);
        $this->assertTrue($settings['tax_included']);
    }

    /**
     * Test is messaging enabled method
     */
    public function testIsMessagingEnabled()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_MESSAGING_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isMessagingEnabled());
    }

    /**
     * Test is anonymous messages allowed method
     */
    public function testIsAnonymousMessagesAllowed()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_MESSAGING_ANONYMOUS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isAnonymousMessagesAllowed());
    }

    /**
     * Test is message moderation required method
     */
    public function testIsMessageModerationRequired()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_MESSAGING_MODERATE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isMessageModerationRequired());
    }

    /**
     * Test is rating enabled method
     */
    public function testIsRatingEnabled()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_RATING_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isRatingEnabled());
    }

    /**
     * Test is purchase required for rating method
     */
    public function testIsPurchaseRequiredForRating()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_RATING_REQUIRE_PURCHASE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isPurchaseRequiredForRating());
    }

    /**
     * Test is anonymous reviews allowed method
     */
    public function testIsAnonymousReviewsAllowed()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_RATING_ANONYMOUS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isAnonymousReviewsAllowed());
    }

    /**
     * Test is review moderation required method
     */
    public function testIsReviewModerationRequired()
    {
        $this->scopeConfigMock->expects($this->once())
            ->method('isSetFlag')
            ->with(Data::XML_PATH_RATING_MODERATE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->willReturn(true);

        $this->assertTrue($this->helper->isReviewModerationRequired());
    }
}

