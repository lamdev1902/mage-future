<?php
namespace MageDev\AssignPattern\Block\Adminhtml\ByBlock\Edit\Tab\Render;

use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Data\Form\Element\Multiselect;
use Magento\Framework\Escaper;
use MageDev\BannerSlider\Helper\Data;
use MageDev\Core\Model\ResourceModel\Test\Collection;
use MageDev\Core\Model\ResourceModel\Test\CollectionFactory as TestCollectionFactory;
use Magento\Framework\Registry;
use Magento\Framework\App\ResourceConnection;

/**
 * Class Core
 * @package MageDev\AssignPattern\Block\Adminhtml\ByBlock\Edit\Tab\Render
 */
class Core extends Multiselect
{
    /**
     * ResourceConnection
     *
     * @var ResourceConnection
     */
    public $resource;

    /**
     * Registry
     *
     * @var Registry
     */
    public $registry;
    /**
     * Authorization
     *
     * @var AuthorizationInterface
     */
    public $authorization;

    /**
     * @var TestCollectionFactory
     */
    public $collectionFactory;

    /**
     * Slider constructor.
     *
     * @param Factory $factoryElement
     * @param CollectionFactory $factoryCollection
     * @param Escaper $escaper
     * @param TestCollectionFactory $collectionFactory
     * @param AuthorizationInterface $authorization
     * @param Registry $registry
     * @param ResourceConnection $resource
     * @param array $data
     */
    public function __construct(
        Factory $factoryElement,
        CollectionFactory $factoryCollection,
        Escaper $escaper,
        TestCollectionFactory $collectionFactory,
        AuthorizationInterface $authorization,
        Registry $registry,
        ResourceConnection $resource,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->authorization = $authorization;
        $this->_coreRegistry = $registry;
        $this->resource = $resource;

        parent::__construct($factoryElement, $factoryCollection, $escaper, $data);
    }

    /**
     * @inheritdoc
     */
    public function getElementHtml()
    {
        $html = '<div class="admin__field-control admin__control-grouped">';
        $html .= '<div id="magedev-assign-byblock" class="admin__field" data-bind="scope:\'assignpattern\'" data-index="index">';
        $html .= '<!-- ko foreach: elems() -->';
        $html .= '<input name="assign[core_ids]" data-bind="value: value" style="display: none"/>';
        $html .= '<!-- ko template: elementTmpl --><!-- /ko -->';
        $html .= '<!-- /ko -->';
        $html .= '</div></div>';

        $html .= $this->getAfterElementHtml();

        return $html;
    }

    /**
     * Attach Blog Tag suggest widget initialization
     *
     * @return string
     */
    public function getAfterElementHtml()
    {
        $html = '<script type="text/x-magento-init">
            {
                "*": {
                    "Magento_Ui/js/core/app": {
                        "components": {
                            "assignpattern": {
                                "component": "uiComponent",
                                "children": {
                                    "assign_select_core": {
                                        "component": "Magento_Catalog/js/components/new-category",
                                        "config": {
                                            "filterOptions": true,
                                            "disableLabel": true,
                                            "chipsEnabled": true,
                                            "levelsVisibility": "1",
                                            "elementTmpl": "ui/grid/filters/elements/ui-select",
                                            "options": ' . Data::jsonEncode($this->getCoreCollection()) . ',
                                            "value": ' . Data::jsonEncode($this->getValues()) . ',
                                            "config": {
                                                "dataScope": "assign_select_core",
                                                "sortOrder": 10
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        </script>';

        return $html;
    }

    /**
     * @return mixed
     */
    public function getCoreCollection()
    {
        /* @var $collection Collection */
        $collection = $this->collectionFactory->create();
        $coreById = [];
        foreach ($collection as $core) {
            $coreId = $core->getId();
            $coreById[$coreId]['value'] = $coreId;
            $coreById[$coreId]['label'] = $core->getCoreName();
        }

        return $coreById;
    }

    /**
     * Get values for select
     *
     * @return array
     */
    public function getValues()
    {
        $assignRegistry = $this->_coreRegistry->registry('assign_byblock');
        $options = [];
        if(!empty($assignRegistry))
        {
            $connection = $this->resource->getConnection();
            $table = $this->resource->getTableName("magedev_assign_pattern_core");

            $query = $connection->select("*")
                ->from($table)
                ->where("assign_id = ?", $assignRegistry->getEntityId());
            $data = $connection->fetchAll($query);
            
            if(!empty($data))
            {
                foreach($data as $item)
                {
                    $options[] = $item['core_id'];
                }
            }
        }

        return $options;
    }
}
