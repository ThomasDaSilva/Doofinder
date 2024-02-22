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
- user id: (Go to user account -> Api Keys)
- token user: (Go to user account -> Api Keys. You will need to generate it)

If your configuration is correct, the information will be displayed in the Search Engine section

### Power your search with Doofinder

There are two ways to power your search:

Configure the Front Hooks (optional if you are add the script manually):
- Hook search script is the hook where the doofinder search script will be added in the front page  
- id of the search Bar is the id of your search bar

Or Manually Add the script (you will need to add your website information)
```
<script type="text/javascript">
        var doofinder_script ='//d3chj0zb5zcn0g.cloudfront.net/media/js/doofinder-3.latest.min.js';
        (function(d,t){
            var f=d.createElement(t),s=d.getElementsByTagName(t)[0];f.async=1;
                f.src=('https:'==location.protocol?'https:':'http:')+doofinder_script;
                s.parentNode.insertBefore(f,s)}(document,'script')
        );
        if(!doofinder){var doofinder={};}
        doofinder.options = {
            lang: 'LANG',
            hashid: 'YOUR_HASH_ID',
            queryInput: '#query_input_id',
            width: 535,
            dleft: -112,
            dtop: 84,
            marginBottom: 0
        }
    </script>
```
At the end of the script you will see a `doofinder.options` section. Here is where you will have to make adjustments.

The Doofinder layer is attached to a search box. To identify that input control, we use a *CSS selector*. In this case the selector is `#query_input_id` that identifies the HTML element with an id attribute with a value of `query_input_id`.

There are three other parameters you probably will want to customize:

- `width`: The width of the layer. Use a number without quotes around it.
- `dleft`: Is the horizontal displacement of the layer from the point where it is placed automatically. You can use a positive or negative number without quotes around it.
- `dtop`: Is the vertical displacement of the layer from the point where it is placed automatically. You can use a positive or negative number without quotes around it.

If you decide to put the search box included with this plugin for the top of the page, you probably will have to adjust these parameters. Remember to do it for each script.

## Synchronize your product with Doofinder
Doofinder needs your product information to be read from a data file located in a public web URL.
This module is working with the API to send you product information and make statistics

To synchronize your products,
you can use the button in the module back-office or synchronize one by saving him 
or use this command : 
```shell
php Thelia module:Doofinder:Synchronize
```

## Documentation

[Doofinder Admin Interface](https://admin.doofinder.com)

Doofinder api :
- [Documentation API Search](https://docs.doofinder.com/api/search/v6/)
- [Documentation API Management](https://docs.doofinder.com/api/management/v2/)

Doofinder php library : 
- [Documentation API Search](https://github.com/doofinder/php-doofinder/blob/master/src/Search/README_SEARCH.md)
- [Documentation API Management](https://github.com/doofinder/php-doofinder/blob/master/src/Management/README_MANAGEMENT.md)