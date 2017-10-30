# Meanbee_InfiniteScroll

A Magento 2 extension that loads additional products on category and search pages without navigating to the next page.

## Installation

Install this extension with Composer:

    composer require meanbee/magento2-infinitescroll

## Usage

The extension is enabled by default and has no configuration options. Once installed (and cache is flushed), it will
replace the pager at the bottom of category and search pages with a "View More" button.

The extension replaces the `Magento_Catalog::product/list.phtml` template with its own, so any changes to the product
list HTML need to be made in `Meanbee_InfiniteScroll::product/list.phtml`.

## Development

### Docker Environment

To configure a Docker development environment, run

    cd dev/ \
    && docker-compose run --rm cli magento-extension-installer Meanbee_InfiniteScroll \
    && docker-compose up -d

The configured environment will be available on [https://m2-meanbee-infinitescroll.docker](https://m2-meanbee-infinitescroll.docker)
