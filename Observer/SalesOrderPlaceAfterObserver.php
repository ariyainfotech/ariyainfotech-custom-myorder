<?php

namespace AriyaInfoTech\MyOrder\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;

class SalesOrderPlaceAfterObserver implements \Magento\Framework\Event\ObserverInterface
{
	
	protected $_eventManager;
	protected $_myOrderHelper;
		
	public function __construct(
        \Magento\Framework\Event\Manager $eventManager,
		\AriyaInfoTech\MyOrder\Helper\Data $myOrderHelper
	) {
        $this->_eventManager = $eventManager;
		$this->_myOrderHelper = $myOrderHelper;
	}
	public function execute(\Magento\Framework\Event\Observer $observer){
		/* @var $order \Magento\Sales\Model\Order */
		$order = $observer->getEvent()->getData('order');
		$lastOrderId = $observer->getOrder()->getId();
		$incrementId = $order->getIncrementId();
		$oredrdate = $order->getCreatedAt();
		if($this->_myOrderHelper->getCustomerId()):
			$customerId = $this->_myOrderHelper->getCustomerId();
			foreach ($order->getAllVisibleItems() as $item):
				$arraycreate = array("seller_id"=>"","order_increment_id"=>$incrementId,"order_id"=>$lastOrderId,"order_item_id"=>$item->getId(),"customer_id"=>$customerId,"status"=>"order_received","order_received_date"=>$oredrdate);
				$this->_myOrderHelper->insertRecored($arraycreate);
			endforeach;
		endif;
		return $this;
	}
}