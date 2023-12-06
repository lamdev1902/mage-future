<?php
namespace MageDev\AssignPattern\Model\Assign\Config\Source;

use Magento\Framework\Option\ArrayInterface;

use MageDev\Core\Model\ResourceModel\Test\CollectionFactory;

class CoreName implements ArrayInterface
{


    public function __construct(
        CollectionFactory $testCollectionFactory ,
    ) {
        $this->testCollectionFactory = $testCollectionFactory;
    }
    public function toOptionArray()
    {
        $data = $this->getOptions();
        return $data;
    }
    public function getOptions()
    {
        $collection = $this->testCollectionFactory->create();
        $items = [];
        foreach($collection->getData() as $item){
            $items[] = [
                'value' => $item['entity_id'], 
                'label' => __($item['core_name'])
            ];
        }

        return $items;
    }
}