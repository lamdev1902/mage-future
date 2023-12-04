<?php
namespace MageDev\ImagePattern\Controller\Adminhtml\ByBlock;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class NewAction
 * @package MageDev\ImagePattern\Controller\Adminhtml\ByBlock
 */
class NewAction extends Action
{
    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
