i have use concept of msp/cmsimportexport and rewrite code based on my requirement like when we are sync Dev Server code with live server at that time commit export file on git and once code move to live site just run command so all data sync...

## Installation
	composer require navin/cmsimportexport

### ## How to export CMS Block

 - php bin/magento export:cmsblock
 
 Note File Exported At :var/navin_cmsimportexport/export

### ## How to export CMS Page

 - php bin/magento export:page
 
 Note File Exported At :var/navin_cmsimportexport/export

### ## How to IMPORT CMS Page/Block

 Upload Import Zip File into app/code/Navin/CmsImportExport/export
 
 ### Command php bin/magento import:cmspageblock --file-name=cms_page.zip --cms-mode=update --media-mode=update
 
 
file-name : name of while which u want to import

cms-mode or media-mode : update -> for override existing Block or Page

cms-mode or media-mode : skip -> for Skip




