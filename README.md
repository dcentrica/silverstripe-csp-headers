# Security headers for Silverstripe

# License

[LGPL v3 or later](LICENSE.md)

### Code status
![Woodpecker-CI](https://ci.codeberg.org/api/badges/12772/status.svg?branch=main)

Adds CSP headers to your request, based on configuration in a yml file.

[Setting up a report-uri account is free and easy](https://report-uri.com)

## Disclaimer

If this module breaks your website, you get to keep all the pieces.

## Requirements

SilverStripe Framework 6.x+
PHP 8.3+

## Installation

`composer require firesphere/cspheaders`

## Configuration and usage

[See the documentation](https://codeberg.org/Firesphere/silverstripe-csp-headers/wiki)

# WARNING

When using this module and have CSS hashes or nonces enabled, any inline styles declared on HTML Elements themselves will not work anymore.

To enable or disable inline javascripts or css, set the appropriate flag (`allow-inline`) in your yml config.

Same goes for javascripts. Javascripts specifically should live either in a separate file, or be added using `Requirementns::customScripts()`

Default for css is therefore `false`, javascript however defaults to `true` for security reasons.

# CDN Providers

When using Incapsula or Imperva (and potentially other CDN providers),
your CSS and JavaScripts may be altered by the CDN, and therefore never compute correctly.

The only solution is to disable the SRI's for css and javascript on these providers.

## .htaccess

Any header set in the `.htaccess`, Apache `site.conf` or `nginx.conf` files will override the headers
set by this module.


# Did you read this entire readme? You rock!

Pictured below is a cow, just for you.
```

               /( ,,,,, )\
              _\,;;;;;;;,/_
           .-"; ;;;;;;;;; ;"-.
           '.__/`_ / \ _`\__.'
              | (')| |(') |
              | .--' '--. |
              |/ o     o \|
              |           |
             / \ _..=.._ / \
            /:. '._____.'   \
           ;::'    / \      .;
           |     _|_ _|_   ::|
         .-|     '==o=='    '|-.
        /  |  . /       \    |  \
        |  | ::|         |   | .|
        |  (  ')         (.  )::|
        |: |   |;  U U  ;|:: | `|
        |' |   | \ U U / |'  |  |
        ##V|   |_/`"""`\_|   |V##
           ##V##         ##V##
```
