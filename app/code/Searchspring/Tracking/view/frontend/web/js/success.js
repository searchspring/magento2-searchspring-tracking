define([
    'underscore',
    'intelliSuggest'
], function (_) {
    'use strict';
    return function (config) {
        if (!config) return;
        var siteId     = config.siteId;
        var productArr = config.products;
        try {
            IntelliSuggest.init({
                siteId: siteId
            });
            _.each(productArr , function (item) {
                IntelliSuggest.haveItem({
                    sku: item.sku,
                    qty: item.qty,
                    price: item.price
                });
            });
            IntelliSuggest.inSale({});
        } catch (err) {
        }
    };
});
