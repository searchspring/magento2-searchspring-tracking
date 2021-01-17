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


