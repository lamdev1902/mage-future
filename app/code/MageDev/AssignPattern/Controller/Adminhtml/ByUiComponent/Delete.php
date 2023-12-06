<?php
namespace MageDev\AssignPattern\Controller\Adminhtml\ByUiComponent;

use Exception;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use MageDev\AssignPattern\Controller\Adminhtml\Assign;

/**
 * Class Delete
 * @package MageDev\AssignPattern\Controller\Adminhtml\ByUiComponent
 */
class Delete extends Assign
{
    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $this->assignFactory->create()
                ->load($this->getRequest()->getParam('id'))
                ->delete();
            $this->messageManager->addSuccess(__('The Assign has been deleted.'));
        } catch (Exception $e) {
            // display error message
            $this->messageManager->addErrorMessage($e->getMessage());
            // go back to edit form
            $resultRedirect->setPath(
                'assign/*/edit',
                ['id' => $this->getRequest()->getParam('entity_id')]
            );

            return $resultRedirect;
        }

        $resultRedirect->setPath('assign/*/');

        return $resultRedirect;
    }
}
