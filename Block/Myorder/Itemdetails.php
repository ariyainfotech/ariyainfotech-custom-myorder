<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\MyOrder\Block\Myorder;

class Itemdetails extends \Magento\Framework\View\Element\Template
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
    ) {
		$this->_myorderHelper = $myorderHelper;	
        parent::__construct($context, $data);
    }

	public function getAllItems(){
		return $this->_myorderHelper->getItemColectionByCustomerId();
	}
	
	public function priceFormate($price){
		return $this->_myorderHelper->setPriceFormate($price);
	}
	
	public function getDateFormate($date){
		return $this->_myorderHelper->setDateFormate($date);
	}
	
	public function productImages($products){
		return $this->_myorderHelper->getProductImages($products);
	}
	
	public function getParemValuesFilterVal(){
		return $this->getRequest()->getParam('item');
	}
	
	public function orderById($oredrId){
		return $this->_myorderHelper->getOrderById($oredrId);
	}
	
	public function getItemByDetails($itemid){
		return $this->_myorderHelper->getOrderItem($itemid);
	}
	
	public function getButton($itemId){
		return $this->_myorderHelper->setButton($itemId);
	}
}

