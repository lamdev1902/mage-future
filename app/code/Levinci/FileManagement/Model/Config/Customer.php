<?php
namespace Levinci\FileManagement\Model\Config;

use Magento\Framework\Option\ArrayInterface;

use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;

class Customer implements ArrayInterface
{

    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory 
     */
    
    private $customerCollectionFactory;

    public function __construct(
        CollectionFactory $customerCollectionFactory,
    ) {
        $this->customerCollectionFactory = $customerCollectionFactory;
    }
    public function toOptionArray()
    {
        $data = $this->getOptions();
        return $data;
    }
    public function getOptions()
    {
        $collection = $this->customerCollectionFactory->create();

        $items = [];
        foreach($collection->getData() as $item){
            $items[] = ['value' => $item['entity_id'], 'label' => $item['firstname']];
        }

        return $items;
    }
}
