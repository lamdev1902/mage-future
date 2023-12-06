<?php
namespace MageDev\AssignPattern\Controller\Adminhtml\ByBlock;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use MageDev\AssignPattern\Controller\Adminhtml\Assign;
use MageDev\AssignPattern\Model\AssignFactory;

/**
 * Class Edit
 * @package MageDev\AssignPattern\Controller\Adminhtml\ByBlock
 */
class Edit extends Assign
{
    const ADMIN_RESOURCE = 'MageDev_AssignPattern::byblock';

    /**
     * Page factory
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Edit constructor.
     *
     * @param PageFactory $resultPageFactory
     * @param AssignFactory $assignFactory
     * @param Registry $registry
     * @param Context $context
     */
    public function __construct(
        PageFactory $resultPageFactory,
        AssignFactory $assignFactory,
        Registry $registry,
        Context $context
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($assignFactory, $registry, $context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|ResponseInterface|Redirect|ResultInterface|Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        /** @var \MageDev\AssignPattern\Model\Assign $assign */
        $assign = $this->initAssign();

        if ($id) {
            $assign->load($id);
            if (!$assign->getId()) {
                $this->messageManager->addError(__('This page no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath(
                    'assign/*/edit',
                    [
                        'entity_id' => $id,
                        '_current' => true
                    ]
                );

                return $resultRedirect;
            }
        }

        $data = $this->_session->getData('magedev_assign_data', true);
        if (!empty($data)) {
            $assign->setData($data);
        }

        /** @var \Magento\Backend\Model\View\Result\Page|Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MageDev_Core::menu');
        $resultPage->getConfig()->getTitle()
            ->set(__('Assigns'))
            ->prepend($assign->getId() ? $assign->getTitle() : __('New Assign'));

        return $resultPage;
    }
}
