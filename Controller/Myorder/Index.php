<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ariya\MyOrder\Controller\Myorder;

class Index extends \Magento\Framework\App\Action\Action
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
		\Ariya\MyOrder\Helper\Data $myorderHelper,
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
    public function execute(){
		if($this->_myorderHelper->getCustomerId()):
			return $this->resultPageFactory->create();
		endif;
		return $this->_redirect('customer/account/login');	
    }
}