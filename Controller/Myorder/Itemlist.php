<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\MyOrder\Controller\Myorder;

class Itemlist extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
	
	protected $_myorderHelper;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
		\AriyaInfoTech\MyOrder\Helper\Data $myorderHelper,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
		$this->_myorderHelper = $myorderHelper;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if($this->_myorderHelper->getCustomerId()):
			//return $this->resultPageFactory->create();
			$resultPage = $this->resultPageFactory->create();
			$navigationBlock = $resultPage->getLayout()->getBlock('customer_account_navigation');
			if ($navigationBlock){
				$navigationBlock->setActive('sale/myorder/index');
			}
			return $resultPage;
		endif;
		return $this->_redirect('customer/account/login');
    }
}