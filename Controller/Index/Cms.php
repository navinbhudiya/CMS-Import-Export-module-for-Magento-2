<?php
namespace Navin\CmsImportExport\Controller\Index;
use Magento\Framework\App\Action\Context;
use Magento\Cms\Api\PageRepositoryInterface;
class Cms extends \Magento\Framework\App\Action\Action{
    protected $helper;
    protected $cmspage;
    public function __construct(Context $context, \Navin\CmsImportExport\Helper\Common $helper,PageRepositoryInterface $cmspage){
        $this->helper = $helper;
        $this->cmspage=$cmspage;
        parent::__construct($context);
    }
    public function execute(){
//        $page=$this->cmspage->getById(7);
//        var_dump($page->getData());exit;
        //$end_point='rest/V1/cmsPage/search?searchCriteria[sortOrders][0][field]=page_id&searchCriteria[sortOrders][0][direction]=asc';
        $end_point='rest/admin/V1/cmsPage/1';
        $items = $this->helper->sendMagentoApiRequest($end_point,'');
        var_dump($items);exit;
        //foreach ($items['items'] as $item):
            var_dump($item);exit;
        //endforeach;
        //exit;
    }
}
