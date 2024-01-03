<?php
namespace Levinci\FileManagement\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
        /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Framework\Controller\ResultFactory
     */
    protected $_resultFactory;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlInterface;

    /**
     * @var \Levinci\FileManagement\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
       \Magento\Framework\View\Result\PageFactory $pageFactory,
       \Levinci\FileManagement\Helper\Data $helper,
       \Magento\Framework\UrlInterface $urlInterface,
       \Magento\Customer\Model\Session $customerSession,
       \Magento\Framework\Controller\ResultFactory $resultFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_helper = $helper;
        $this->_urlInterface = $urlInterface;
        $this->_customerSession = $customerSession;
        $this->_resultFactory = $resultFactory;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if(!$this->_helper->getCustomerId()) {
            $url = $this->_urlInterface->getCurrentUrl();
            $this->_customerSession->setLoginReferUrl($url);
            $redirect = $this->_resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
            $redirect->setUrl('/customer/account/login');
        
        return $redirect;
    }
        return $this->_pageFactory->create();
    }
}
