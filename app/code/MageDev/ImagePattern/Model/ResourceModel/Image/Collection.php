<?php
namespace MageDev\ImagePattern\Model\ResourceModel\Image;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'magedev_imgpattern_image_collection';
    protected $_eventObject = 'image_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('MageDev\ImagePattern\Model\Image', 'MageDev\ImagePattern\Model\ResourceModel\Image');
    }
}
