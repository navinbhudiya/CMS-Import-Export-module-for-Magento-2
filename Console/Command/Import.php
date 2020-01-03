<?php
namespace Navin\CmsImportExport\Console\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Module\Dir;
use Magento\Framework\File\UploaderFactory;
use Navin\CmsImportExport\Api\ContentInterface;
use Navin\CmsImportExport\Model\Filesystem;
use Magento\Store\Api\StoreRepositoryInterface;
class Import extends Command{
    protected $directoryList;
    protected $module_dir;
    protected $uploaderFactory;
    protected $contentInterface;
    protected $filesystem;
    protected $storeRepositoryInterface;
    public function __construct(DirectoryList $directoryList,Dir $module_dir,UploaderFactory $uploaderFactory,ContentInterface $contentInterface,Filesystem $filesystem,StoreRepositoryInterface $storeRepositoryInterface){
        parent::__construct();
        $this->directoryList = $directoryList;
        $this->module_dir=$module_dir;
        $this->contentInterface = $contentInterface;
        $this->filesystem = $filesystem;
        $this->storeRepositoryInterface = $storeRepositoryInterface;
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input,OutputInterface $output){
        if(!$input->getOption('file-name')):
            $output->writeln('Please enter file name which you want to import.');
        else:
            $file_name=$this->module_dir->getDir('Navin_CmsImportExport').'/export/'.$input->getOption('file-name');
            if(file_exists($file_name)):
                $output->writeln('Import Process started...!');
                $stores = $this->storeRepositoryInterface->getList();
                $cmsMode = $input->getOption('cms-mode');
                $mediaMode = $input->getOption('media-mode');
                $storesMap=array();
                foreach ($stores as $storeInterface) :
                    $storesMap[$storeInterface->getCode()]=$storeInterface->getCode();
                endforeach;
                $this->contentInterface->setCmsMode($cmsMode)->setMediaMode($mediaMode)->setStoresMap($storesMap);
                $count = $this->contentInterface->importFromZipFile($file_name, true);
                $output->writeln(__('A total of %1 item(s) have been imported/updated.', $count));
            else:
                $output->writeln("{$file_name} file does not exist");
            endif;
        endif;
    }
    /**
     * {@inheritdoc}
     */
    protected function configure(){
        $this->setName("import:cmspageblock");
        $this->setDescription("Sync CMS Page & Block");
        $this->addOption('file-name', null, InputOption::VALUE_REQUIRED, "File Name");
        $this->addOption('cms-mode', null, InputOption::VALUE_REQUIRED, "CMS import mode");
        $this->addOption('media-mode', null, InputOption::VALUE_REQUIRED, "Media import mode");
        parent::configure();
    }
}
