# SemExpert_StoreInfoBlocks

SemExpert_StoreInfoBlocks enables developers to include Magento blocks in their themes that have access to Store 
Configuration like address, phone number, etc.

[![Build Status](https://travis-ci.org/SemExpert/StoreInfoBlocks.svg?branch=master)](https://travis-ci.org/SemExpert/StoreInfoBlocks)

## Getting Started

To get started you only need to add the module to an existing Magento2 installation.

### Prerequisites

You need a running copy of Magento2

Also, in order for composer to locate the module repository, you need to have set up SemExpert repository:

```bash
php composer.phar config repositories.semexpert composer https://packages.semexpert.com.ar/
```

### Install

To get StoreInfoBlocks up and running, you need to add it as a dependency to your Magento composer.json file

Either edit composer.json

```json
{
  "require": {
    "semexpert/module-store-info-blocks": "*"
  }
}
```

or run composer require

```bash
php composer.phar require semexpert/module-store-info-blocks
```

after installing, you need to enable via the Magento CLI

```bash
php bin/magento module:enable SemExpert_StoreInfoBlocks
```

## Running tests

This module provides only unit tests that can be hooked into Magento testsuite in the standard way

```bash
php bin/magento dev:tests:run unit
```

In order to run  this module's tests exclusively you can use the provided `dev/phpunit.xml` configuration file.

```bash
vendor/bin/phpunit -c vendor/semexpert/moodule-store-info-blocks/dev/phpunit.xml
```

I found no need for integration or functional tests as of yet. And also I am unsure about how to write those.

### Coding Styles

The module follows Magento 2.2 PHP and Less coding standards. You should test your code using the provided black/white 
lists and phpunit.xml configuration.

```bash
cp ./dev/tests/static/phpunit.xml dev/tests/static/phpunit.xml
cp ./dev/tests/static/less/whitelist/common.txt dev/tests/static/testsuite/Magento/Test/Less/_files/whitelist/common.txt
cp ./dev/tests/static/php/whitelist/common.txt dev/tests/static/testsuite/Magento/Test/Php/_files/whitelist/common.txt
```

## Magento 2

### Components

The module provides 2 types of blocks

* `SemExpert\StoreInfoBlocks\Block\Template` Provides a stadard Template block with access to store configuration 
information
* `SemExpert\StoreInfoBlocks\Block\Value` Allow to output a single configuration value without formatting. Requires some
setup via layout xml

These blocks are available for use in your custom themes but are not automatically included anywhere on the site.

### Usage

#### Template

By simply calling the Template block in a layout, the provided storeinfo.phtml template will be used which is provided 
only as an example 

```xml
<?xml version="1.0"?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
      xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceContainer name="header.panel">
            <block class="SemExpert\StoreInfoBlocks\Block\Template" name="header.storeinfo" />
        </referenceContainer>
    </body>
</page>
```

or you can provide your own template. Within the template, you can access a DataObject containing the store information
by calling `$block->getStoreInformation()`

*default.xml*

```xml
<?xml version="1.0"?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
      xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceContainer name="header.panel">
            <block class="SemExpert\StoreInfoBlocks\Block\Template" name="header.storeinfo" 
                   template="storeinfo-modal-window.phtml" />
        </referenceContainer>
    </body>
</page>
```

*storeinfo-modal-window.phtml*

```php
<?php $storeInfo = $block->getStoreInfo(); ?>
<div class="call-us">
    <strong>Call Us at:</strong> <?= $storeInfo->getData('phone') ?> <?= $storeInfo->getData('hours') ?>
</div>
```

Available data keys are:

* name
* phone
* hours
* street_line1
* street_line2
* city
* postcode
* region_id
* region
* country_id
* country
* vat_number

#### Value

You can set up a value block via layout XML to retrieve a single unformatted value

*contact_index_index.xml*

```xml
<?xml version="1.0"?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
      xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceBlock name="contactForm">
            <block class="SemExpert\StoreInfoBlocks\Block\Value" name="storephone">
                <arguments>
                    <argument name="key" type="xsi:string">phone</argument>
                </arguments>
            </block>
        </referenceContainer>
    </body>
</page>
```

*app/design/SemExpert/CustomTheme/Magento_Contact/templates/form.phtml*

```php
<form>
    <!-- ... -->
</form>

<p>
    Or call us at <a href=tel:<?= $block->getChildHtml('storephone') ?>"><?= $block->getChildHtml('storephone') ?></a>
</p>  
```

Check the description for Template block for a list of accepted values for the `key` argument.

## Versioning

We use [SemVer](http://semver.org/) for versioning. To see available versions, check the [tags for this repository](https://github.com/SemExpert/StoreInfoBlocks/tags). 


## Authors

* **Matías Montes** - *Initial work* - [barbazul](https://github.com/barbazul)

Also check the list of [contributors](https://github.com/SemExpert/StoreInfoBlocks/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Thanks to everybody involved in [this thread](https://magento.stackexchange.com/questions/125354/how-to-get-store-phone-number-in-magento-2) that served as an inspiration for the module.
* [alepasian](https://github.com/alepasian) and [lupeportias](https://github.com/lupeportias) for hacking your way into M2 limitations.
