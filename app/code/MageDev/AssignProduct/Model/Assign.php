<?php
namespace MageDev\AssignProduct\Model;

class Assign extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'magedev_assign_assign';

    /**
     * Model cache tag for clear cache in after save and after delete
     *
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'assign';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('MageDev\AssignProduct\Model\ResourceModel\Assign');
    }

    /**
     * Return a unique id for the model.
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array
     */
    public function getAssignProductMatch($assignId = null)
    {
        $adapter = $this->getResource()->getConnection();

        $table = $this->getResource()->getTable("magedev_assign_product_match_product");

        $query = $adapter->select("*")
                ->from($table)
                ->where("assign_id = ?", $this->getId() ?? $assignId);

        $data = $adapter->fetchAll($query);

        $assignProductId = [];
        foreach($data as $assignProductItem)
        {
            $assignProductId[] = $assignProductItem['product_id'];
        }

        return $assignProductId;
    }
}
