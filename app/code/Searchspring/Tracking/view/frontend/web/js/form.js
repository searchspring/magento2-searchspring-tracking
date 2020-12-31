define([
    'intelliSuggest'
], function () {
    'use strict';
    return function (config) {
        if (!config) return;

        var sku    = config.sku;
        var siteId = config.siteId;

        try {
            IntelliSuggest.init({
                siteId: siteId,
                context: 'Product/' + sku,
                seed: [
                    sku
                ]
            });
            IntelliSuggest.viewItem({
                sku: sku
            });
        } catch (err) {
        }
    };
});
