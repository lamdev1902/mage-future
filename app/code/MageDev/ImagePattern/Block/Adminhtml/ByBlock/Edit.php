<?php
namespace MageDev\ImagePattern\Block\Adminhtml\ByBlock;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;
use MageDev\ImagePattern\Model\Image;

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
     * Initialize Test edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'entity_id';
        $this->_blockGroup = 'MageDev_ImagePattern';
        $this->_controller = 'adminhtml_byblock';
        parent::_construct();
        $this->buttonList->update('save', 'label', __('Save Image'));
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
        $this->buttonList->update('delete', 'label', __('Delete Image'));
    }

    /**
     * Retrieve text for header element depending on loaded Test
     *
     * @return string
     */
    public function getHeaderText()
    {
        /** @var Banner $banner */
        $imagePattern = $this->getImagePattern();
        if ($imagePattern->getId()) {
            return __("Edit Image '%1'", $this->escapeHtml($imagePattern->getName()));
        }

        return __('New Image');
    }

    /**
     * @return mixed
     */
    public function getImagePattern()
    {
        return $this->coreRegistry->registry('registry_image');
    }
}
