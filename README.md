# NativeMind Marketplace Module for Magento 2

[![Latest Stable Version](https://poser.pugx.org/nativemind/module-marketplace/v/stable)](https://packagist.org/packages/nativemind/module-marketplace)
[![License](https://poser.pugx.org/nativemind/module-marketplace/license)](https://packagist.org/packages/nativemind/module-marketplace)
[![Total Downloads](https://poser.pugx.org/nativemind/module-marketplace/downloads)](https://packagist.org/packages/nativemind/module-marketplace)

Transform your Magento 2 store into a powerful marketplace platform similar to Avito, Facebook Marketplace, Shopee, Lazada, AliExpress, or Ozone. Enable multiple sellers to create their own stores with subdomains or subdirectories, manage products (new and used), and build a thriving marketplace ecosystem.

## 🚀 Features

### 🏪 **Multi-Seller Platform**
- **Seller Registration & Verification** - Complete seller onboarding with document verification
- **Individual Seller Stores** - Each seller gets their own store with custom branding
- **Subdomain/Subdirectory Support** - `seller1.yourstore.com` or `/seller/seller1/`
- **Seller Dashboard** - Comprehensive management interface for sellers
- **Seller Profiles** - Public profiles with ratings, reviews, and statistics

### 🛍️ **Product Management**
- **New & Used Products** - Support for both new and second-hand items
- **Advanced Product Attributes** - Custom fields for marketplace-specific data
- **Bulk Product Import/Export** - CSV/Excel support for large catalogs
- **Product Moderation** - Admin approval workflow for new products
- **Inventory Management** - Real-time stock tracking per seller

### ⭐ **Rating & Review System**
- **Seller Ratings** - Overall seller performance scoring
- **Product Reviews** - Detailed product feedback from buyers
- **Review Moderation** - Admin controls for review approval
- **Rating Analytics** - Comprehensive seller performance metrics

### 💬 **Communication Tools**
- **Internal Messaging** - Direct buyer-seller communication
- **Order Messaging** - Contextual messaging tied to orders
- **Notification System** - Email and in-app notifications
- **Dispute Resolution** - Built-in conflict resolution tools

### 💰 **Commission & Payment**
- **Flexible Commission Rates** - Configurable commission per category/seller
- **Multi-Payment Methods** - Support for various payment gateways
- **Escrow System** - Secure payment holding until order completion
- **Payout Management** - Automated seller payouts with reporting

### 🎛️ **Admin Management**
- **Seller Management** - Approve, suspend, or manage seller accounts
- **Commission Settings** - Configure commission rates and rules
- **Dispute Resolution** - Handle buyer-seller conflicts
- **Analytics Dashboard** - Comprehensive marketplace analytics
- **Content Moderation** - Review and approve products/reviews

### 🌐 **Multi-Store Support**
- **Subdomain Configuration** - Easy subdomain setup for sellers
- **Subdirectory Support** - Alternative path-based seller stores
- **Custom Themes** - Seller-specific store themes
- **SEO Optimization** - Individual SEO settings per seller store

### 📱 **Mobile & API Support**
- **REST API** - Complete API for mobile app integration
- **GraphQL Support** - Modern API for frontend applications
- **Mobile-Optimized** - Responsive design for all devices
- **PWA Ready** - Progressive Web App capabilities

## 📋 Requirements

- **Magento 2.4.x** (2.4.0 or higher)
- **PHP 7.4+** (8.1+ recommended)
- **MySQL 5.7+** or **MariaDB 10.2+**
- **Elasticsearch 7.x** (for advanced search)
- **Redis** (for caching, recommended)

### Optional Dependencies
- **NativeMind Translation Module** - For multi-language marketplace support
- **Elasticsearch** - For advanced product search and filtering
- **Varnish** - For improved performance

## 🛠️ Installation

### Via Composer (Recommended)

```bash
composer require nativemind/module-marketplace
php bin/magento module:enable NativeMind_Marketplace
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento cache:flush
```

### Manual Installation

```bash
# 1. Download and extract module
mkdir -p app/code/NativeMind/Marketplace
# Extract module files to app/code/NativeMind/Marketplace

# 2. Enable module
php bin/magento module:enable NativeMind_Marketplace

# 3. Run setup
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento cache:flush
```

## ⚙️ Configuration

### 1. Basic Setup

Navigate to **Stores > Configuration > NativeMind > Marketplace** to configure:

- **Enable Marketplace** - Activate marketplace functionality
- **Seller Registration** - Configure seller signup process
- **Commission Settings** - Set default commission rates
- **Subdomain Configuration** - Configure seller subdomains

### 2. Seller Subdomain Setup

#### Option A: Subdomains (seller1.yourstore.com)

```bash
# Add to your web server configuration
*.yourstore.com -> yourstore.com
```

#### Option B: Subdirectories (/seller/seller1/)

```bash
# Configure URL rewrites in Magento admin
# Stores > Configuration > Web > URL Options
```

### 3. Payment Configuration

Configure payment methods for marketplace:
- **Escrow Payments** - Hold payments until order completion
- **Commission Collection** - Automatic commission deduction
- **Seller Payouts** - Automated seller payment processing

## 🎯 Usage Examples

### Seller Registration

```php
// Enable seller registration
$sellerRegistration = $this->sellerRegistrationFactory->create();
$sellerRegistration->setData([
    'email' => 'seller@example.com',
    'firstname' => 'John',
    'lastname' => 'Doe',
    'company' => 'John\'s Store',
    'tax_id' => '123456789'
]);
$sellerRegistration->save();
```

### Product Management

```php
// Add product to seller's catalog
$product = $this->productFactory->create();
$product->setData([
    'name' => 'Used iPhone 12',
    'sku' => 'used-iphone-12-001',
    'price' => 599.99,
    'seller_id' => 123,
    'condition' => 'used',
    'description' => 'Excellent condition iPhone 12...'
]);
$product->save();
```

### API Integration

```php
// Get seller's products via API
GET /rest/V1/marketplace/seller/123/products

// Create new product via API
POST /rest/V1/marketplace/seller/123/products
{
    "product": {
        "name": "Product Name",
        "price": 99.99,
        "condition": "new"
    }
}
```

## 🔧 Advanced Configuration

### Custom Seller Attributes

```xml
<!-- Add custom seller attributes -->
<fieldset name="seller_information">
    <field name="business_license" formElement="file">
        <argument name="data" xsi:type="array">
            <item name="config" xsi:type="array">
                <item name="label" xsi:type="string">Business License</item>
            </item>
        </argument>
    </field>
</fieldset>
```

### Commission Rules

```php
// Set category-specific commission rates
$commissionRule = $this->commissionRuleFactory->create();
$commissionRule->setData([
    'category_id' => 15,
    'commission_rate' => 8.5,
    'seller_group' => 'premium'
]);
$commissionRule->save();
```

## 📊 Analytics & Reporting

### Seller Dashboard Metrics
- **Sales Performance** - Revenue, orders, conversion rates
- **Product Performance** - Best-selling items, inventory levels
- **Customer Feedback** - Reviews, ratings, response rates
- **Financial Reports** - Commissions, payouts, earnings

### Admin Analytics
- **Marketplace Overview** - Total sellers, products, orders
- **Revenue Analytics** - Commission income, growth trends
- **Seller Performance** - Top performers, inactive sellers
- **Product Analytics** - Popular categories, search trends

## 🔒 Security Features

- **Seller Verification** - Document verification system
- **Product Moderation** - Admin approval for new products
- **Fraud Detection** - Automated suspicious activity detection
- **Data Protection** - GDPR compliance for seller data
- **Secure Payments** - PCI-compliant payment processing

## 🌍 Multi-Language Support

Integrate with **NativeMind Translation Module** for:
- **Automatic Translation** - Translate product descriptions
- **Multi-Store Support** - Different languages per seller store
- **Localized Content** - Region-specific marketplace features

## 📱 Mobile Integration

### Flutter Integration
```dart
// Using flutter_magento package
final marketplace = FlutterMagento();
await marketplace.getSellerProducts(sellerId: '123');
await marketplace.createSellerAccount(sellerData);
```

### React Native Integration
```javascript
// Using react-native-magento package
import { MagentoMarketplace } from 'react-native-magento';

const marketplace = new MagentoMarketplace();
await marketplace.getSellerStore(sellerId);
```

## 🧪 Testing

```bash
# Run unit tests
vendor/bin/phpunit tests/unit/

# Run integration tests
vendor/bin/phpunit tests/integration/

# Run API tests
vendor/bin/phpunit tests/api/
```

## 📈 Performance Optimization

- **Elasticsearch Integration** - Fast product search
- **Redis Caching** - Improved page load times
- **CDN Support** - Global content delivery
- **Database Optimization** - Indexed queries for large catalogs
- **Image Optimization** - Automatic image compression

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

### Development Setup

```bash
# Clone repository
git clone https://github.com/nativemind/module-marketplace.git
cd module-marketplace

# Install dependencies
composer install

# Run tests
vendor/bin/phpunit
```

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

- **Documentation** - [Full Documentation](https://docs.nativemind.net/marketplace)
- **Issues** - [GitHub Issues](https://github.com/nativemind/module-marketplace/issues)
- **Community** - [Magento Community](https://community.magento.com/)
- **Email Support** - support@nativemind.net

## 🗺️ Roadmap

### Version 2.0 (Q2 2024)
- [ ] Advanced AI-powered product recommendations
- [ ] Blockchain integration for authenticity verification
- [ ] Advanced analytics with machine learning
- [ ] Mobile app SDK improvements

### Version 2.1 (Q3 2024)
- [ ] Multi-currency support with automatic conversion
- [ ] Advanced shipping integration
- [ ] Social commerce features
- [ ] Voice search integration

## 📞 Contact

- **Website** - [nativemind.net](https://nativemind.net)
- **Email** - contact@nativemind.net
- **Twitter** - [@NativeMindDev](https://twitter.com/NativeMindDev)

---

**Transform your Magento store into a powerful marketplace today!** 🚀
