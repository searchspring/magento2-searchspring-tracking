define([
    'consoleLogger',
    'itemsTracking',
    'Magento_Customer/js/customer-data',
    'intelliSuggest'
], function (consoleLogger, itemsTracking, customerData) {
    'use strict';

    return function (config) {
        if (!config) return;

        var siteId     = config.siteId;
        var productArr = config.products;
        var trackingData = customerData.get('searchspring-tracking')();
        var shopperId = trackingData.shopper_id;

        try {
            IntelliSuggest.init({
                siteId: siteId
            });
            if (shopperId) {
                IntelliSuggest.setShopperId(shopperId);
            }
            itemsTracking(productArr)
            IntelliSuggest.inSale({});
        } catch (err) {
            consoleLogger.error(err)
        }
    };
});
