define([
    'jquery',
    'ko',
    'uiComponent',
], function ($, ko, Component) {
    'use strict';

    return Component.extend({
        state: {
            products: [],
            isMoreAvailable: false,
            isFetching: false,
        },

        pageParam: 'p',
        ajaxParam: 'ajax',

        initialize: function () {
            this._super();

            this.state.products = ko.observableArray(this.state.products);
            this.state.isMoreAvailable = ko.observable(this.state.isMoreAvailable);
            this.state.isFetching = ko.observable(false);
        },

        /**
         * Load additional products from the server.
         */
        loadMore: function () {
            if (!this.state.isMoreAvailable()) {
                return;
            }

            this.state.isFetching(true);

            fetch(this._getFetchUrl(true))
                .then(function (response) { return response.json(); })
                .then(this._updateState.bind(this))
                .then((function () { this._updateHistory(this._getFetchUrl(false)) }).bind(this));
        },

        /**
         * Get the URL for fetching additional products.
         *
         * @param is_ajax
         * @return string
         * @private
         */
        _getFetchUrl: function (is_ajax) {
            const url = new URL(window.location);
            const currentPage = parseInt(url.searchParams.get(this.pageParam) || 1);

            url.searchParams.set(this.pageParam, currentPage + 1);

            if (is_ajax) {
                url.searchParams.set(this.ajaxParam, "true");
            }

            return url.href;
        },

        /**
         * Update component state with the provided data.
         *
         * @param data
         * @private
         */
        _updateState: function (data) {
            this.state.isMoreAvailable(data.isMoreAvailable || false);
            data.products.forEach((function (product) { this.state.products.push(product); }).bind(this));
            this.state.isFetching(false);
        },

        /**
         * Update the history state with a new product list URL.
         *
         * @param url
         * @private
         */
        _updateHistory: function (url) {
            history.replaceState({}, document.title, url);
        },
    });
});
