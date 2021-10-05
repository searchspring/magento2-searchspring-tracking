# How to Install #

1. Add the Searchspring Tracking repository to composer: `composer config repositories.searchspring git "https://github.com/searchspring/magento2-searchspring-tracking.git"`
2. Require the Searchspring Tracking module: `composer require searchspring/magento2-searchspring-tracking`
3. Install the Searchspring Tracking module: `bin/magento setup:upgrade`
4. Configure the Searchspring Tracking module in the Magento 2 admin:
    1. Navigate to Stores > Settings > Configuration
    2. Navigate to Searchspring > Searchspring
    3. Enter your Searchspring Site ID.
    4. Click Save Config.
5. Flush your Magento 2 cache: `bin/magento cache:flush`


# Module Information #
**MODULE**                                  | Searchspring_Tracking Magento 2 Module
--------------------------------------------|----------------
**DESCRIPTION**                             | The purpose of this module is to automatically install the Searchspring Intellisuggest tracking scripts onto a client’s Magento 2 site through the use of a module.
**HOW TO START USE**                        | For usage start you must add your Searchspring site id in Admin panel (Stores->Configuration->Searchspring Tracking)
**HOW MODULE WORKS**                        | This module works on 3 pages: Product Detail Page, Cart Page, Checkout Success Page. 
**HOW MODULE WORKS ON PRODUCT DETAIL PAGE** | Searchspring Tracking module sends via AJAX product SKU to searchspring account. If product has parent, searchspring sends parent SKU.  
**HOW MODULE WORKS ON CART PAGE**           | Searchspring Tracking module collect product SKUs and sends via AJAX to searchspring account. If product has parent, searchspring sends parent SKU. Also searchspring with SKUs sends price and quantity.
**HOW MODULE WORKS ON SUCCESS PAGE**        | The same as on Cart Page case
**HOW TO EXTEND**                           | You can add any product type for your needs. For example in di.xml to pool which you need, then you can create your resolver
**REQUIRED VERSIONS**                       | PHP 7.2+, Magento 2.3.x/2.4.x


# Extending the Module #

In app/code/Searchspring/Tracking/etc/frontend/di.xml you can add your custom product type, for example

```xml
<type name="Searchspring\Tracking\Service\CompositeOrderItemPriceResolver">
    <arguments>
        <argument name="orderItemPriceResolversPool" xsi:type="array">
            <item name="yourProductType" xsi:type="object">Searchspring\Tracking\Service\YourProductTypeItemPriceResolver</item>
        </argument>
    </arguments>
</type>
```

Then add to app/code/Searchspring/Tracking/Service directory your custom class, for example `YourProductTypeItemPriceResolver.php`:

```php
class YourProductTypeItemPriceResolver implements OrderItemPriceResolverInterface
{
    public function getProductPrice(OrderItemInterface $product): ?float
    {
        //your custom code
    }
}
```


Also you can do the same for `quoteItem`:

```xml
<type name="Searchspring\Tracking\Service\CompositeOrderItemPriceResolver">
    <arguments>
        <argument name="quoteItemPriceResolversPool" xsi:type="array">
            <item name="yourProductType" xsi:type="object">Searchspring\Tracking\Service\YourProductTypeItemPriceResolver</item>
        </argument>
    </arguments>
</type>
```

Then add to `app/code/Searchspring/Tracking/Service` directory your custom class, for example `YourProductTypeItemPriceResolver.php`:

```php
class YourProductTypeItemPriceResolver implements QuoteItemPriceResolverInterface
{
    public function getProductPrice(CartItemInterface $product): ?float
    {
        //your custom code
    }
}
```


Also you can do the same for `quoteItem`:

```xml
<type name="Searchspring\Tracking\Service\CompositeSkuResolver">
    <arguments>
        <argument name="skuResolversPool" xsi:type="array">
            <item name="yourProductType" xsi:type="object">Searchspring\Tracking\Service\YourProductTypeSkuResolver</item>
        </argument>
    </arguments>
</type>
```

`YourProductTypeItemSkuResolver.php`:

```php
class YourProductTypeSkuResolver implements SkuResolverInterface
{ 
    public function getProductSku($product): ?string
    {
        //your custom code
    }
}
```

# API Integrations #
This module does not include product click tracking for search results. This click tracking is part of the Searchspring White Glove JavaScript Catalog. If you are doing a direct API integration you will need to manually integrate search results click tracking into your integration. You can find more information [here](https://searchspring.zendesk.com/hc/en-us/articles/201185129-Adding-IntelliSuggest-Tracking#productclicks).

