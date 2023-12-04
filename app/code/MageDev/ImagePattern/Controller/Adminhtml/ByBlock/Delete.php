<?php
namespace MageDev\ImagePattern\Controller\Adminhtml\ByBlock;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
class Delete extends \Magento\Backend\App\Action
{


    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
       \Magento\Backend\App\Action\Context $context,
       \MageDev\ImagePattern\Model\ImageFactory $imgFactory,
       ResultFactory $resultFactory,
       Filesystem $fileSystem,
       File $file
    )
    {
        $this-$imgFactory = $imgFactory;
        $this->fileSystem = $fileSystem;
        $this->file = $file;
        $this->resultFactory = $resultFactory;
        
        return parent::__construct($context);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        try {
            $id = $this->getRequest()->getParam('entity_id');
            if(isset($id)){
                $model = $this-$imgFactory->create()->load($id);

                $model->delete();
                
            }
            $this->messageManager->addSuccess(__('A total of image %1 have been deleted.',$id));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }


}
