# Mage2 Module Ariya MyOrder

    ``ariya/module-myorder``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities


## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Ariya`
 - Enable the module by running `php bin/magento module:enable Ariya_MyOrder`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require ariya/module-myorder`
 - enable the module by running `php bin/magento module:enable Ariya_MyOrder`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration




## Specifications

 - Controller
	- frontend > customer/myorder/list

 - Controller
	- frontend > customer/myorder/details

 - Controller
	- frontend > customer/myorder/itemdetails

 - Controller
	- frontend > customer/myorder/itemcancel

 - Controller
	- frontend > customer/myorder/itemcancelsuccess

 - Controller
	- frontend > customer/myorder/itemreturn

 - Controller
	- frontend > customer/myorder/itemreturnsubmitted

 - Controller
	- frontend > customer/myorder/opendispute

 - Controller
	- frontend > customer/myorder/opendisputesucess

 - Helper
	- Ariya\MyOrder\Helper\Data


## Attributes



