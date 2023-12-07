<?php 
namespace MageDev\AssignProduct\Block\Adminhtml\Products\Edit;

class AssignProducts extends \Magento\Backend\Block\Template
{
    /**
     * Block template
     *
     * @var string
     */
    protected $_template = 'products/assign_products.phtml';

    /**
     * @var \Magento\Catalog\Block\Adminhtml\Category\Tab\Product
     */
    protected $blockGrid;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * @var \MageDev\AssignProduct\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context                           $context
     * @param \Magento\Framework\Registry                                       $registry
     * @param \Magento\Framework\Json\EncoderInterface                          $jsonEncoder
     * @param \MageDev\AssignProduct\Model\ResourceModel\Product\CollectionFactory $productFactory
     * @param \MageDev\AssignProduct\Model\Assign $assign,
     * @param array                                                             $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \MageDev\AssignProduct\Model\ResourceModel\Product\CollectionFactory $productFactory,
        \MageDev\AssignProduct\Model\Assign $assign,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->jsonEncoder = $jsonEncoder;
        $this->productFactory = $productFactory;
        $this->assign = $assign;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve instance of grid block
     *
     * @return \Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getBlockGrid()
    {
        if (null === $this->blockGrid) {
            $this->blockGrid = $this->getLayout()->createBlock(
                'MageDev\AssignProduct\Block\Adminhtml\Products\Edit\Tab\Product',
                'category.product.grid'
            );
        }
        return $this->blockGrid;
    }

    /**
     * Return HTML of grid block
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getBlockGrid()->toHtml();
    }

    /**
     * @return string
     */
    public function getProductsJson()
    {
        $assignId = $this->getRequest()->getParam('id');
        if($assignId)
        {
            $assignProduct = $this->assign->getAssignProductMatch($assignId);
            $productFactory = $this->productFactory->create();
            $entityArr = [];
            foreach($assignProduct as $productId)
            {
                $entityArr[] = $productId;
            }
            if(!empty($entityArr))
            {
                $productFactory->addFieldToFilter('entity_id', ['in' => $entityArr]);
                $result = [];
                if (!empty($productFactory->getData())) {
                    foreach ($productFactory->getData() as $rhProducts) {
                        $result[$rhProducts['entity_id']] = '';
                    }
                    return $this->jsonEncoder->encode($result);
                }
            }           
        }
        return '{}';

    }

    public function getItem()
    {
        return $this->registry->registry('my_item');
    }
}
