<?php

namespace MageDev\AssignProduct\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\Registry;
use MageDev\AssignProduct\Model\AssignFactory;

/**
 * Class Assign
 * @package MageDev\AssignProduct\Controller\Adminhtml
 */
abstract class Assign extends Action
{
    /**
     * Assign Factory
     *
     * @var AssignFactory
     */
    protected $assignFactory;

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * Result redirect factory
     *
     * @var RedirectFactory
     */

    /**
     * constructor
     *
     * @param AssignFactory $assignFactory
     * @param Registry $coreRegistry
     * @param Context $context
     */
    public function __construct(
        AssignFactory $assignFactory,
        Registry $coreRegistry,
        Context $context
    ) {
        $this->assignFactory = $assignFactory;
        $this->coreRegistry = $coreRegistry;

        parent::__construct($context);
    }

    /**
     * Init Assign
     *
     * @return \MageDev\AssignProduct\Model\Assign
     */
    protected function initAssign()
    {
        $assignId = (int)$this->getRequest()->getParam('entity_id');
        /** @var \MageDev\AssignProduct\Model\Assign $assign */
        $assign = $this->assignFactory->create();
        if ($assignId) {
            $assign->load($assignId);
        }
        $this->coreRegistry->register('assign_byblock', $assign);

        return $assign;
    }
}
