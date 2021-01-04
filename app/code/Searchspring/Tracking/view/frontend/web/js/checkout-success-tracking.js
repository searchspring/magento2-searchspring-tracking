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

        try {
            IntelliSuggest.init({
                siteId: siteId
            });
            itemsTracking(productArr)
            IntelliSuggest.inSale({});
        } catch (err) {
            consoleLogger.error(err)
        }
    };
});
