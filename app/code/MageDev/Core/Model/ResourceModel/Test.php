<?php
namespace MageDev\Core\Model\ResourceModel;

class Test extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('magedev_core_test', 'entity_id');
    }
}
