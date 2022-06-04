<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ariya\MyOrder\Controller\Myorder;

class Statusupdate extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $jsonHelper;
	protected $_myorderHelper;
	protected $messageManager;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
		\Magento\Framework\Message\ManagerInterface $messageManager,
		\Ariya\MyOrder\Helper\Data $myorderHelper,
		
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
        $this->logger = $logger;
		$this->_myorderHelper = $myorderHelper;
		$this->messageManager = $messageManager;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
			$itemid = $this->getRequest()->getParam('itemid');
			$status = $this->getRequest()->getParam('status');
			$itemCollection = $this->_myorderHelper->getItemCollection();
			$itemCollection->addFieldToFilter("order_item_id",$itemid);
			$todayDate = Date('y-m-d');
				foreach($itemCollection as $item):
					$item->setStatus($status);
					if($status == 'packed'):
						$item->setPackedDate($todayDate);
					endif;	
					if($status == 'delivered'):
						$item->setDeliveredDate($todayDate);
					endif;	
					$item->save();
				endforeach;
			//$this->messageManager->addSuccess(__("Item Status Updated Successfully"));
			return $this->jsonResponse('done');
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            return $this->jsonResponse($e->getMessage());
			//$this->messageManager->addWarning(__($e->getMessage()));
        } catch (\Exception $e) {
            $this->logger->critical($e);
			//$this->messageManager->addError(__($e->getMessage()));
            return $this->jsonResponse($e->getMessage());
        }
    }

    /**
     * Create json response
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function jsonResponse($response = '')
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($response)
        );
    }
}
