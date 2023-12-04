<?php
namespace MageDev\ImagePattern\Block\Adminhtml\ByBlock\Edit\Tab;

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
use MageDev\ImagePattern\Block\Adminhtml\ByBlock\Edit\Tab\Render\Image as ByBlockImage;
use MageDev\ImagePattern\Helper\Image as HelperImage;


/**
 * Class Banner
 * @package MageDev\ImagePattern\Block\Adminhtml\ByBlock\Edit\Tab
 */
class Image extends Generic implements TabInterface
{
    /**
     * helper image
     *
     * @var HelperImage
     */
    protected $helperImage;

    /**
     * Type options
     *
     * @var Type
     */
    protected $typeOptions;

    /**
     * Status options
     *
     * @var Enabledisable
     */
    protected $statusOptions;

    // /**
    //  * @var HelperImage
    //  */
    // protected $imageHelper;

    /**
     * @var FieldFactory
     */
    protected $_fieldFactory;

    /**
     * @var DataObject
     */
    protected $_objectConverter;

    /**
     * @var WysiwygConfig
     */
    protected $_wysiwygConfig;

    /**
     * Banner constructor.
     *
     * @param Type $typeOptions
     * @param Enabledisable $statusOptions
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param FieldFactory $fieldFactory
     * @param DataObject $objectConverter
     * @param WysiwygConfig $wysiwygConfig
     * @param HelperImage $helperImage
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
        HelperImage $helperImage,
        array $data = []
    ) {
        $this->statusOptions = $statusOptions;
        $this->_fieldFactory = $fieldFactory;
        $this->_objectConverter = $objectConverter;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->helperImage = $helperImage;
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
        /** @var \MageDev\ImagePattern\Model\Image $banner */
        $imgPattern = $this->_coreRegistry->registry('registry_image');
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('image_');
        $form->setFieldNameSuffix('image');
        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => __('Test Information'),
            'class' => 'fieldset-wide'
        ]);

        if ($imgPattern->getId()) {
            $fieldset->addField(
                'entity_id',
                'hidden',
                ['name' => 'entity_id']
            );
        }

        $fieldset->addField('title', 'text', [
            'name' => 'title',
            'label' => __('Title'),
            'title' => __('Title'),
            'required' => true,
        ]);

        $uploadBanner = $fieldset->addField('image', ByBlockImage::class, [
            'name' => 'image',
            'label' => __('Upload Image'),
            'title' => __('Upload Image'),
            'path' => $this->helperImage->getBaseMediaPath(HelperImage::TEMPLATE_MEDIA_TYPE_BY_BLOCK)
        ]);


        if($imgPattern)
        {
            $form->addValues($imgPattern->getData());
        }
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
