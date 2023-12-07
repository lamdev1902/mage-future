<?php
namespace MageDev\AssignProduct\Model\ResourceModel\Assign;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'magedev_assignproduct_assign_collection';
    protected $_eventObject = 'assign_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('MageDev\AssignProduct\Model\Assign', 'MageDev\AssignProduct\Model\ResourceModel\Assign');
    }
}
