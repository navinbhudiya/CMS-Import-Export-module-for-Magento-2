<?php
namespace Navin\CmsImportExport\Helper;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
class Common extends AbstractHelper {

    protected $logger;
    protected $scopeConfig;
    protected $category_collection_factory;
    protected $resource;

    public function __construct(Context $context, StoreManagerInterface $storeManager, \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory, \Magento\Framework\App\ResourceConnection $resource) {
        parent::__construct($context);
        $this->logger = $context->getLogger();
        $this->scopeConfig = $context->getScopeConfig();
        $this->storeManager = $storeManager;
        $this->sourceurl = $this->getStoreConfig('api/general/sourceurl');
        $this->magento_token = $this->getStoreConfig('api/general/token');
        $this->category_collection_factory = $categoryCollectionFactory;
        $this->resource = $resource;
    }
    #########################################################################################
    # All Comman function
    #########################################################################################

    public function getStoreConfig($storePath){
        $storeConfig = $this->scopeConfig->getValue($storePath, ScopeInterface::SCOPE_STORE);
        return $storeConfig;
    }

    public function log($info){
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/connection.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info($info);
    }
    public function getStoreUrl() {
        return $this->storeManager->getStore()->getBaseUrl();
    }
    ###################################################################################################
    # Function for API Connection
    ###################################################################################################
    public function getMagentoAuthorisationHeader($payload = '') {
        $headers = ['Content-Type: application/json','Accept: application/json','Authorization:Bearer ' . $this->magento_token];
        return $headers;
    }
    public function sendMagentoApiRequest($endpoint, $payload, $type = 'GET') {
        $endpoint=$this->sourceurl.$endpoint;
        $headers=$this->getMagentoAuthorisationHeader();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        if ($type == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        } else if ($type == 'POST') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        }
        if (!empty($payload)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_POST, 1);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        $result = curl_exec($ch);
        if ($result === false) {
            $this->log(curl_error($ch));
            curl_close($ch);
            return false;
        } else {
            curl_close($ch);
            return json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $result), true);
        }
    }
    public function getStoreCodeById($store_id){
        $stores = $this->storeManager->getStores(true, false);
        foreach ($stores as $store) {
            if ($store->getId() === $store_id) {
                return $store->getCode();
            }
        }
        return false;
    }
}