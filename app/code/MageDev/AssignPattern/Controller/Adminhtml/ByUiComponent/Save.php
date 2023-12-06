<?php
declare(strict_types=1);

namespace MageDev\AssignPattern\Controller\Adminhtml\ByUiComponent;

use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
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
    \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
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
        $data = $this->getRequest()->getPostValue();
        if ($data) {

            if(isset($data['entity_id'])){
                $model = $this->_objectManager->create(\MageDev\AssignPattern\Model\Assign::class)->load($data['entity_id']);
                if (!$model->getEntityId()) {
                    $this->messageManager->addErrorMessage(__('This Assign no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            else {
                $model = $this->_objectManager->create(\MageDev\AssignPattern\Model\Assign::class);
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the assign.'));
                $this->dataPersistor->clear('assign');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getEntityId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the assign.'));
            }

            $this->dataPersistor->set('assign', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}