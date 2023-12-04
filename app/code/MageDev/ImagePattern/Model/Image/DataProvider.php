<?php
namespace MageDev\ImagePattern\Model\Image;
 
use MageDev\ImagePattern\Model\ResourceModel\Image\CollectionFactory as ImageCollection;
use MageDev\ImagePattern\Helper\Data;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    /**
     * @var ImageCollection $imageCollection
     */
    protected $imageCollection;


    /**
     * @var Data $helper
     */
    protected $helper;
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ImageCollection $imageCollection
     * @param Data $helper
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ImageCollection $imageCollection,
        Data $helper,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $imageCollection->create();
        $this->helper = $helper;
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

        if(!empty($items)){
            foreach($items as $item)
                $this->loadedData[$item->getEntityId()]  = $item->getData();
                if($item->getImage()){
                    $thumbnail['image'][0]['name'] = $item->getImage();
                    $thumbnail['image'][0]['url'] = $this->helper->getMediaUrl().$item->getImage();
                    $fullData = $this->loadedData;
                    $this->loadedData[$item->getEntityId()] = array_merge($fullData[$item->getEntityId()],$thumbnail);
                }
            return $this->loadedData;
        }
        
        return [];
    }

    
    
}