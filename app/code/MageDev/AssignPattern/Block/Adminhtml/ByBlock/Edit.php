<?php
namespace MageDev\AssignPattern\Block\Adminhtml\ByBlock;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;
use MageDev\AssignPattern\Model\Assign;

/**
 * Class Edit
 * @package MageDev\AssignPattern\Block\Adminhtml\ByBlock
 */
class Edit extends Container
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * constructor
     *
     * @param Registry $coreRegistry
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Registry $coreRegistry,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->coreRegistry = $coreRegistry;
    }

    /**
     * Initialize Assign edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'entity_id';
        $this->_blockGroup = 'MageDev_AssignPattern';
        $this->_controller = 'adminhtml_byblock';
        parent::_construct();
        $this->buttonList->update('save', 'label', __('Save'));
        $this->buttonList->add(
            'save-and-continue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ]
                    ]
                ]
            ],
            -100
        );
        $this->buttonList->update('delete', 'label', __('Delete'));
    }

    /**
     * Retrieve text for header element depending on loaded Assign
     *
     * @return string
     */
    public function getHeaderText()
    {
        /** @var Assign $assign */
        $assign = $this->getAssign();
        if ($assign->getId()) {
            return __("Edit '%1'", $this->escapeHtml($assign->getTitle()));
        }

        return __('New');
    }

    /**
     * @return mixed
     */
    public function getAssign()
    {
        return $this->coreRegistry->registry('assign_byblock');
    }
}
