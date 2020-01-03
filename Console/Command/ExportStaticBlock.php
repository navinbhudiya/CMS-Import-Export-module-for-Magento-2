<?php
namespace Navin\CmsImportExport\Console\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Cms\Model\ResourceModel\Block\CollectionFactory;
use Magento\Framework\Module\Dir;
use Navin\CmsImportExport\Api\ContentInterface as ImportExportContentInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\App\Filesystem\DirectoryList;
class ExportStaticBlock extends Command{
    protected $collectionFactory;
    protected $moduleReader;
    protected $filesystem;
    protected $dateTime;
    protected $directory_list;
    public function __construct(Dir $moduleReader,CollectionFactory $collectionFactory,DateTime $dateTime,ImportExportContentInterface $importExportContentInterface,DirectoryList $directory_list){
        $this->moduleReader = $moduleReader;
        $this->collectionFactory=$collectionFactory;
        $this->dateTime = $dateTime;
        $this->importExportContentInterface = $importExportContentInterface;
        $this->directory_list = $directory_list;
        parent::__construct();
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input,OutputInterface $output){
        $collection =$this->collectionFactory->create();
        $pages = [];
        $output->writeln("Static Block Export Process starting....");
        foreach ($collection as $page){
            $output->write("....");
            $pages[] = $page;
            $output->write("....");
        }
        $output->writeln("");
        try {
            if(!empty($pages)):
                $file_name = $this->importExportContentInterface->asZipFile([],$pages);
                $show_file_name = $this->directory_list->getPath('var') . '/' . $file_name;
                    if (!empty($file_name)):
                        $output->writeln("Static Block successfully export at {$show_file_name}");
                    else:
                        $output->writeln("Error while export pages.....");
                    endif;
                else:
                    $output->writeln("Data not found...!");
            endif;
        }catch(Exception $e){
            $output->writeln("Error while export static block.....");
            $output->writeln($e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(){
        $this->setName("export:cmsblock");
        $this->setDescription("Export CMS Block");
        parent::configure();
    }
}
