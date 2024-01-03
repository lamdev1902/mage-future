<?php
namespace Levinci\FileManagement\Controller\Upload;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Levinci\FileManagement\Model\FileManagementFactory;
 
class File extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Levinci\FileManagement\Helper\Data
     */
    protected $_helper;

    /**
    * @var FileManagementFactory
    */
    protected $_fileManagement;
    
    /**
    * @var UploaderFactory
    */
    protected $_uploaderFactory;
    
    
    /**
    * @var Filesystem
    */
    protected $_filesystem;
    
    /**
    * @param Context $context
    * @param ConfigInterface $contactsConfig
    * @param MailInterface $mail
    * @param DataPersistorInterface $dataPersistor
    * @param LoggerInterface $logger
    */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        FileManagementFactory $fileManagement,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        \Levinci\FileManagement\Helper\Data $helper
    ) {
        $this->_uploaderFactory = $uploaderFactory;
        $this->_filesystem = $filesystem;
        $this->_fileManagement = $fileManagement;
        $this->_helper = $helper;
        parent::__construct($context);
    }
    
    /**
    * Execute view action
    * @return \Magento\Framework\Controller\ResultInterface
    */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        if ($data) {
            $files = $this->getRequest()->getFiles();
            $resultRedirect = $this->resultRedirectFactory->create();
            if (isset($files['resume']) && !empty($files['resume']["name"])){
                try {
                    $customerId = $this->_helper->getCustomerId();
                    if(!$customerId){
                        $resultRedirect->setPath('*/index/index');
                        return $resultRedirect;
                    }
                    $uploaderFactory = $this->_uploaderFactory->create(['fileId' => 'resume']);
                    $uploaderFactory->setAllowedExtensions(['pdf', 'docx', 'doc']);
                    $uploaderFactory->setAllowRenameFiles(true);
                    //$uploaderFactory->setFilesDispersion(true);
                    $mediaDirectory = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA);
                    $destinationPath = $mediaDirectory->getAbsolutePath('levinci');
                    $result = $uploaderFactory->save($destinationPath);

                    if (!$result) {
                        throw new LocalizedException(
                            __('File cannot be saved to path: $1', $destinationPath)
                        );
                    }
                    $filePath = $result['file'];
                
                    //Set file path with name for save into database
                    $data['file'] = 'levinci/'.$filePath;
                    $data['customer_id'] = $customerId;
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                }
            
            $_fileManagement = $this->_fileManagement->create();
            $_fileManagement->setData($data);

            if($_fileManagement->save()){

                $this->messageManager->addSuccessMessage(__('You saved the data.'));

            }else{

                $this->messageManager->addErrorMessage(__('Data was not saved.'));
                
            }
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('*/index/index');
                return $resultRedirect;
            }
        }
    }
}
