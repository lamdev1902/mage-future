<?php
namespace MageDev\AssignPattern\Model\ResourceModel;
use Magento\Framework\Model\AbstractModel;

class Assign extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
        $this->assignCoreTable = $this->getTable('magedev_assign_pattern_core');
    }

    protected function _construct()
    {
        $this->_init('magedev_assign_pattern', 'entity_id');
    }

    /**
     * @param AbstractModel $object
     *
     * @return AbstractDb
     */
    protected function _afterSave(AbstractModel $object)
    {
        $this->saveCoreRelation($object);

        return parent::_afterSave($object);
    }

    /**
     * @param \MageDev\AssignPattern\Model\Assign $assign
     *
     * @return $this
     */
    protected function saveCoreRelation(\MageDev\AssignPattern\Model\Assign $assign)
    {
        $id = $assign->getEntityId();
        $coreIds = $assign->getCoreIds();
        $oldCoreIds = $assign->getCoresIds();
        $adapter = $this->getConnection();

        if(!empty($coreIds))
        {
            if(is_string($coreIds))
            {
                $coreIds = explode(',',$coreIds);
            }
            $coresIds = array_filter($coreIds, function($value) {
                return $value !== '';
            });
        }else {
            return $this;
        }

        if(!empty($oldCoreIds))
        {
            $insert = array_diff($coresIds, $oldCoreIds);
            $delete = array_diff($oldCoreIds, $coresIds);

            if(!empty($delete))
            {
                $condition = ['core_id IN(?)' => $delete, 'assign_id=?' => $id];
                $adapter->delete($this->assignCoreTable, $condition);
            }

            if(!empty($insert))
            {
                $data = [];
                foreach($insert as $coreId)
                {
                    $data[] = [
                        'assign_id' => (int)$id,
                        'core_id' => (int)$coreId,
                        'position' => 0
                    ];
                }
                $adapter->insertMultiple($this->assignCoreTable, $data);
            }
        }else {
            $assignCoreData = [];
            foreach($coresIds as $currentCoreId)
            {
                $assignCoreData[] = [
                    'assign_id' => (int)$id,
                    'core_id' => (int)$currentCoreId,
                    'position' => 0
                ];
            }
            $adapter->insertMultiple($this->assignCoreTable, $assignCoreData);
        }
        return $this;
    }
}
