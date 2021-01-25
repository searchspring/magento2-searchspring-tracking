define([
    'consoleLogger',
    'itemsTracking',
    'intelliSuggest'
], function (consoleLogger, itemsTracking) {
    'use strict';

    return function (config) {
        if (!config) return;

        var siteId     = config.siteId;
        var productArr = config.products;
        var skuArr     = config.sku;

        try {
            IntelliSuggest.init({
                siteId: siteId,
                context: 'Basket',
                seed: skuArr
            });
            itemsTracking(productArr)
            IntelliSuggest.inBasket({});
        } catch (err) {
            consoleLogger.error(err)
        }
    };
});
