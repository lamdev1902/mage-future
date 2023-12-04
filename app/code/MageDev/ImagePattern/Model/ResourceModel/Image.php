<?php
namespace MageDev\ImagePattern\Model\ResourceModel;

class Image extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('magedev_image_pattern', 'entity_id');
    }
}
