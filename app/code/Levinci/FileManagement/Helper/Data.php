<?php
namespace Levinci\FileManagement\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
       \Magento\Store\Model\StoreManagerInterface $storeManager,
       \Magento\Customer\Model\Session $customerSession
    )
    {
        $this->storeManager = $storeManager;
        $this->_customerSession = $customerSession;
        parent::__construct($context); 
    }

    public function getBaseUrl(){
        return $baseUrl = $this->storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_WEB,
            $this->storeManager->getStore()->isCurrentlySecure()
        ); 
    }

    public function getBaseUrlMedia(){
        return $baseUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA,
            $this->storeManager->getStore()->isCurrentlySecure()
        ); 
    }
    public function getCustomerId()
    {
        return $this->_customerSession->getCustomer()->getId() ?? "";
    }
}
