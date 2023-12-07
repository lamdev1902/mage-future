<?php
namespace MageDev\AssignProduct\Model\ResourceModel;
use Magento\Framework\Model\AbstractModel;

class Assign extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
        $this->assignProductTable = $this->getTable('magedev_assign_product_match_product');
    }

    protected function _construct()
    {
        $this->_init('magedev_assign_product', 'entity_id');
    }

    /**
     * @param AbstractModel $object
     *
     * @return AbstractDb
     */
    protected function _afterSave(AbstractModel $object)
    {
        $this->saveProductRelation($object);

        return parent::_afterSave($object);
    }

    /**
     * @param \MageDev\AssignProduct\Model\Assign $assign
     *
     * @return $this
     */
    protected function saveProductRelation(\MageDev\AssignProduct\Model\Assign $assign)
    {
        $id = $assign->getEntityId();
        $productIds = $assign->getAssignProducts();
        $oldProductIds = $assign->getAssignProductMatch();
        $adapter = $this->getConnection();
        $productsIds = [];
        if(!empty($productIds))
        {
            
            foreach(json_decode($productIds, true) as $key => $value)
            {
                $productsIds[] = $key;
            }
            $productsIds = array_filter($productsIds, function($value) {
                return $value !== '';
            });
        }else {
            return $this;
        }

        if(!empty($oldProductIds))
        {
            $insert = array_diff($productsIds, $oldProductIds);
            $delete = array_diff($oldProductIds, $productsIds);

            if(!empty($delete))
            {
                $condition = ['product_id IN(?)' => $delete, 'assign_id=?' => $id];
                $adapter->delete($this->assignProductTable, $condition);
            }

            if(!empty($insert))
            {
                $data = [];
                foreach($insert as $coreId)
                {
                    $data[] = [
                        'assign_id' => (int)$id,
                        'product_id' => (int)$coreId
                    ];
                }
                $adapter->insertMultiple($this->assignProductTable, $data);
            }
        }else {
            $assignProductData = [];
            foreach($productsIds as $currentProductId)
            {
                $assignProductData[] = [
                    'assign_id' => (int)$id,
                    'product_id' => (int)$currentProductId,
                ];
            }
            $adapter->insertMultiple($this->assignProductTable, $assignProductData);
        }
        return $this;
    }
}
