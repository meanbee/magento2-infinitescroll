# Meanbee_InfiniteScroll

A Magento 2 extension that loads additional products on category pages without navigating to the next page.

## Installation

Install this extension with Composer:

    composer require meanbee/magento2-infinitescroll

## Development

### Docker Environment

To configure a Docker development environment, run

    cd dev/ \
    && docker-compose run --rm cli magento-extension-installer Meanbee_InfiniteScroll \
    && docker-compose up -d

The configured environment will be available on [https://m2-meanbee-infinitescroll.docker](https://m2-meanbee-infinitescroll.docker)
