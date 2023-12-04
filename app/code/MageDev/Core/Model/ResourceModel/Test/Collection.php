<?php
namespace MageDev\Core\Model\ResourceModel\Test;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'magedev_core_test_collection';
    protected $_eventObject = 'test_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('MageDev\Core\Model\Test', 'MageDev\Core\Model\ResourceModel\Test');
    }
}
