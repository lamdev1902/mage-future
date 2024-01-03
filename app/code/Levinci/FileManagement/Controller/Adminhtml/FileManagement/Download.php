<?php
namespace Levinci\FileManagement\Controller\Adminhtml\FileManagement;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Download extends Action
{
    public $fileManagementFactory;
    
    public function __construct(
        Context $context,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Filesystem\DirectoryList $directory,
        \Levinci\FileManagement\Model\FileManagementFactory $fileManagementFactory
    ) {
         $this->fileManagementFactory = $fileManagementFactory;
         $this->_downloader = $fileFactory;
         $this->directory = $directory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        try {
            $fileModel = $this->blogFacfileManagementFactorytory->create();
            $fileModel->load($id);
            $fileName = $fileModel->getFile();
            $file = $this->directory->getPath("media").$fileName;
            return $this->_downloader->create(
                   $fileName,
                   @file_get_contents($file)
             );
            $this->messageManager->addSuccessMessage(__('You downloaded the pdf file.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultRedirect->setPath('*/*/');
    }
}