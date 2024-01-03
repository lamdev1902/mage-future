<?php
namespace Levinci\FileManagement\Model\ResourceModel\FileManagement;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'levinci_filemanagement_file_management_collection';
    protected $_eventObject = 'file_management_collection';

    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Levinci\FileManagement\Model\FileManagement', 'Levinci\FileManagement\Model\ResourceModel\FileManagement');
    }
}
