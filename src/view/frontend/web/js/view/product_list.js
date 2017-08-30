define([
    'jquery',
    'ko',
    'uiComponent',
], function ($, ko, Component) {
    'use strict';

    return Component.extend({
        products: [],

        initialize: function () {
            this._super();
            this.observe('products');
        }
    });
});
