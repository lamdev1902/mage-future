<?php
declare(strict_types=1);

namespace MageDev\ImagePattern\Controller\Adminhtml\ByBlock;

use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use MageDev\ImagePattern\Helper\Image;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
    * @param \Magento\Backend\App\Action\Context $context
    * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    */
    public function __construct(
    \Magento\Backend\App\Action\Context $context,
    \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
    Filesystem $fileSystem,
    File $file,
    Image $imageHelper
    ) {
    $this->dataPersistor = $dataPersistor;
    $this->fileSystem = $fileSystem;
    $this->file = $file;
    $this->imageHelper = $imageHelper;
    parent::__construct($context);
    }

    /**
    * Save action
    *
    * @return \Magento\Framework\Controller\ResultInterface
    */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue('image');
        if ($data) {
            // helper image sẽ thêm image vào $data
            $this->imageHelper->uploadImage($data, 'image', Image::TEMPLATE_MEDIA_TYPE_BY_BLOCK, null);

            $id = $this->getRequest()->getParam('id');

            if(isset($data['entity_id'])){
                $model = $this->_objectManager->create(\MageDev\ImagePattern\Model\Image::class)->load($data['entity_id']);
                if (!$model->getEntityId()) {
                    $this->messageManager->addErrorMessage(__('This image no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            else {
                $model = $this->_objectManager->create(\MageDev\ImagePattern\Model\Image::class);
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the image.'));
                $this->dataPersistor->clear('image');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getEntityId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the image.'));
            }

            $this->dataPersistor->set('image', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}