<?php
namespace MageDev\AssignProduct\Model\Assign;
 
use MageDev\AssignProduct\Model\ResourceModel\Assign\CollectionFactory;
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $employeeCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $assignCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $assignCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
 
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if(isset($this->loadedData)){
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        if($items){
            foreach($items as $item){
                $itemData['assign']  = $item->getData();
                $this->loadedData[$item->getEntityId()] = $itemData;
            }
            return $this->loadedData;
        }
        
        return [];
    }
}