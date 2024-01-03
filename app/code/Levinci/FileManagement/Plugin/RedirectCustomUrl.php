<?php
namespace Levinci\FileManagement\Plugin;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Customer\Model\Session;

class RedirectCustomUrl
{

    /**
     * @var ResultFactory 
     */
    protected $_resultFactory;

    /**
     * @var Session 
     */
    protected $_session;

    public function __construct(
        ResultFactory $resultFactory, 
        Session $session,
    )
    {
        $this->_resultFactory = $resultFactory;
        $this->_session = $session;
    }

    public function afterExecute(
        \Magento\Customer\Controller\Account\LoginPost $subject,
        $result,
        )
    {
        $url = $this->_session->getLoginReferUrl();


        if($url){
            $redirect = $this->_resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
            $redirect->setUrl($url);
            $this->_session->setLoginReferUrl('');

            return $redirect;
        }
        return $result;

    }
}
