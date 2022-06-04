<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\MyOrder\Block\Myorder;

class Itemfilter extends \Magento\Framework\View\Element\Template
{
	protected $_myorderHelper;
	
    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
		\AriyaInfoTech\MyOrder\Helper\Data $myorderHelper,
        array $data = []
    ){
		$this->_myorderHelper = $myorderHelper;
        parent::__construct($context, $data);
    }
	
	public function getAllOrders(){
		return $this->_myorderHelper->getCustomerOrder();
	}
	
	public function getParemFilterValues(){
		return $this->getRequest()->getParam('filterby');
	}
	
	public function priceFormate($price){
		return $this->_myorderHelper->setPriceFormate($price);
	}
	
	public function getDateFormate($date){
		return $this->_myorderHelper->setDateFormate($date);
	}
	
	public function orderById($orderid){
		return $this->_myorderHelper->getOrderById($orderid);
	}
	
	public function productImages($products){
		return $this->_myorderHelper->getProductImages($products);
	}

	
	public function formattedAddress($address){
        return $this->_myorderHelper->getFormattedAddress($address);
    }
	
	public function getOredrCounts(){
		return $this->_myorderHelper->getAallOrderCount();
	}
	
	public function getPendingCounts(){
		return $this->_myorderHelper->getPendingOrderCount();
	}
	
	public function getProcessingCount(){
		return $this->_myorderHelper->getProcessingOrderCount();
	}
	
	public function getCompleteCount(){
		return $this->_myorderHelper->getCompleteOrderCount();
	}
	
	public function getCanceledCount(){
		return $this->_myorderHelper->getCanceledOrderCount();
	}	
	public function getClosedCount(){
		return $this->_myorderHelper->getClosedOrderCount();
	}	
	
	public function getDeliveredCount(){
		return $this->_myorderHelper->getDeliveredOrderCount();
	}
	
	public function getAllItemCount(){
		$allItems = $this->_myorderHelper->getItemColectionByCustomerId();	
		return count($allItems);
	}
	
	public function getDeliveredItemCount(){
		$allItems = $this->_myorderHelper->getItemColectionByCustomerId();	
		$allItems->addFieldToFilter('status', 'delivered');
		return count($allItems);
	}
	
	public function getWattingDeliveryItemCount(){
		$allItems = $this->_myorderHelper->getItemColectionByCustomerId();	
		$allItems->addFieldToFilter('status', array('order_received','shipped','packed'));
		return count($allItems);
	}
	
	public function getReturnedItemCount(){
		$allItems = $this->_myorderHelper->getItemColectionByCustomerId();	
		$allItems->addFieldToFilter('status','returned');
		return count($allItems);
	}
	
	public function getCancelledItemCount(){
		$allItems = $this->_myorderHelper->getItemColectionByCustomerId();	
		$allItems->addFieldToFilter('status','cancelled');
		return count($allItems);
	}
	
	public function getDisputesItemCount(){
		$allItems = $this->_myorderHelper->getItemColectionByCustomerId();	
		$allItems->addFieldToFilter('status','disputes');
		return count($allItems);
	}
	
}