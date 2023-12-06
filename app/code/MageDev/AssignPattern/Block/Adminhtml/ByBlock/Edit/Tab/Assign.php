<?php
namespace MageDev\AssignPattern\Block\Adminhtml\ByBlock\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Button;
use Magento\Backend\Block\Widget\Form\Element\Dependence;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Cms\Model\Wysiwyg\Config as WysiwygConfig;
use Magento\Config\Model\Config\Source\Enabledisable;
use Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory;
use Magento\Framework\Convert\DataObject;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use MageDev\AssignPattern\Block\Adminhtml\ByBlock\Edit\Tab\Render\Core;

/**
 * Class Assign
 * @package MageDev\AssignPattern\Block\Adminhtml\ByBlock\Edit\Tab
 */
class Assign extends Generic implements TabInterface
{
    /**
     * Type options
     *
     * @var Type
     */
    protected $typeOptions;

    /**
     * Template options
     *
     * @var Template
     */
    protected $template;

    /**
     * Status options
     *
     * @var Enabledisable
     */
    protected $statusOptions;

    /**
     * @var DataObject
     */
    protected $_objectConverter;

    /**
     * Assign constructor.
     *
     * @param Type $typeOptions
     * @param Template $template
     * @param Enabledisable $statusOptions
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param HelperImage $imageHelper
     * @param FieldFactory $fieldFactory
     * @param DataObject $objectConverter
     * @param WysiwygConfig $wysiwygConfig
     * @param array $data
     */
    public function __construct(
        Enabledisable $statusOptions,
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        FieldFactory $fieldFactory,
        DataObject $objectConverter,
        WysiwygConfig $wysiwygConfig,
        array $data = []
    ) {
        $this->statusOptions = $statusOptions;
        $this->_fieldFactory = $fieldFactory;
        $this->_objectConverter = $objectConverter;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('General');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @return Generic
     * @throws LocalizedException
     */
    protected function _prepareForm()
    {
        /** @var \MageDev\AssignPattern\Model\Assign $assign */
        $assign = $this->_coreRegistry->registry('assign_byblock');
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('assign_');
        $form->setFieldNameSuffix('assign');
        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => __('Assign Information'),
            'class' => 'fieldset-wide'
        ]);

        if ($assign->getId()) {
            $fieldset->addField(
                'entity_id',
                'hidden',
                ['name' => 'entity_id']
            );
        }

        $titleBanner = $fieldset->addField('title', 'text', [
            'name' => 'title',
            'label' => __('Assign title'),
            'title' => __('Assign title'),
        ]);


        $fieldset->addField('cores_ids', Core::class, [
            'name' => 'cores_ids',
            'label' => __('Cores'),
            'title' => __('Cores'),
        ]);
        // if (!$assign->getSlidersIds()) {
        //     $assign->setSlidersIds($assign->getSliderIds());
        // }

        $assignData = $this->_session->getData('magedev_assign_data', true);
        if ($assignData) {
            $assign->addData($assignData);
        }

        $dependencies = $this->getLayout()->createBlock(Dependence::class)
            ->addFieldMap($titleBanner->getHtmlId(), $titleBanner->getName());



        // define field dependencies
        $this->setChild('form_after', $dependencies);

        $form->addValues($assign->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
