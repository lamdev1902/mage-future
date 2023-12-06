<?php
namespace MageDev\AssignPattern\Model\Assign;
 
use MageDev\AssignPattern\Model\ResourceModel\Assign\CollectionFactory;
use MageDev\AssignPattern\Model\Assign;
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $employeeCollectionFactory
     * @param Assign $assign
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $assignCollectionFactory,
        Assign $assign,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $assignCollectionFactory->create();
        $this->assign = $assign;
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
                $itemData  = $item->getData();
                $coreData = $this->assign->getCoresIds($item->getEntityId());
                if(!empty($coreData))
                {
                    foreach($coreData as $core)
                    {
                        $itemData['core_ids'][] = $core;
                    }                    
                }
                $this->loadedData[$item->getEntityId()] = $itemData;
            }
            return $this->loadedData;
        }
        
        return [];
    }
}