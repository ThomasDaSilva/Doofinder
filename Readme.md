# Doofinder

This module allows to configure the [Doofinder](http://www.doofinder.com) search service to your Thelia Website

Doofinder allows your website to display your product information to your customer

## Installation

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/doofinder-module:~1.0
```

## Usage

This Module has three configuration sections:

- **Configuration:** to configure the information of your Doofinder search engine.
- **Search Engine:** to show your search engine data.
- **Front Hooks:** to configure the front hooks (optional).

### Configure Doofinder

First, configure your module with your search engine and user information
All information are on your [Doofinder Admin Interface](https://admin.doofinder.com)

Information required :
- server of the search engine: (probably eu1 or us1)
- hash_id of the search engine
- index name: the name of the index that receives products (usually `products`)
- user id: (Go to user account -> Api Keys)
- token user: (Go to user account -> Api Keys. You will need to generate it)

If your configuration is correct, the information will be displayed in the Search Engine section

### Power your search with Doofinder

Doofinder generates a script for your search engine (Live Layer). In your Doofinder
admin interface, copy the installation script provided for your site. It looks like:

```
<script src="https://eu1-config.doofinder.com/2.x/YOUR_INSTALLATION_ID.js" async></script>
```

Then, in the **Front Hooks** section of the module configuration, fill in:

- **Search script:** paste the full Doofinder script here. It is rendered as-is in the
  front-office, so the module works with any script format Doofinder provides.
- **Hook Search Script:** the Thelia hook where the script is injected in the front
  pages (defaults to `main.content-top`).

The layer attaches itself to your site's search input(s) according to the configuration
you set in your Doofinder admin interface — nothing else to declare in Thelia.

## Synchronize your product with Doofinder
Doofinder needs your product information to be read from a data file located in a public web URL.
This module is working with the API to send you product information and make statistics

To synchronize your products,
you can use the button in the module back-office or synchronize one by saving him 
or use this command : 
```shell
php Thelia module:doofinder:synchronize
```

Notes: 
- Inactive products and Exclude products are not sent to Doofinder
- You can exclude a product by checking the checkbox on your product Bo page
- Everytime you are updating your product, it will be synchronized with Doofinder

## Documentation

[Doofinder Admin Interface](https://admin.doofinder.com)

Doofinder api :
- [Documentation API Search](https://docs.doofinder.com/api/search/v6/)
- [Documentation API Management](https://docs.doofinder.com/api/management/v2/)

Doofinder php library : 
- [Documentation API Search](https://github.com/doofinder/php-doofinder/blob/master/src/Search/README_SEARCH.md)
- [Documentation API Management](https://github.com/doofinder/php-doofinder/blob/master/src/Management/README_MANAGEMENT.md)