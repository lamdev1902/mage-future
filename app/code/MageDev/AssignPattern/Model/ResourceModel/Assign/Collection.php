<?php
namespace MageDev\AssignPattern\Model\ResourceModel\Assign;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'magedev_assignpattern_assign_collection';
    protected $_eventObject = 'assign_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('MageDev\AssignPattern\Model\Assign', 'MageDev\AssignPattern\Model\ResourceModel\Assign');
    }
}
