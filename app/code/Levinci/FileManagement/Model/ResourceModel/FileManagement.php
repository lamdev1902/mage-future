<?php
namespace Levinci\FileManagement\Model\ResourceModel;

class FileManagement extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('user_file_management', 'entity_id');
    }
}
