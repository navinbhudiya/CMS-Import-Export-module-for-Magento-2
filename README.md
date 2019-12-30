# Mage2 Module Navin CmsImportExport

    ``navin/cmsimportexport``

## Main Functionalities


## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Navin`
 - Enable the module by running `php bin/magento module:enable Navin_CmsImportExport`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require navin/cmsimportexport`
 - enable the module by running `php bin/magento module:enable Navin_CmsImportExport`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration

 - source Website URL (api/general/sourceurl)


## Specifications

 - Console Command
	- SyncStaticBlock

 - Console Command
	- SyncCmsPage


## Attributes



