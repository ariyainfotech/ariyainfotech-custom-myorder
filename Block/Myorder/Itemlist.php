<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ariya\MyOrder\Block\Myorder;

class Itemlist extends \Magento\Framework\View\Element\Template
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
		\Ariya\MyOrder\Helper\Data $myorderHelper,
        array $data = []
    ) {
		$this->_myorderHelper = $myorderHelper;
        parent::__construct($context, $data);
    }
	
	protected function _prepareLayout(){
        parent::_prepareLayout();
        if ($this->getAllItemsCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'custom.history.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)->setCollection(
                    $this->getAllItemsCollection()
                );
            $this->setChild('pager', $pager);
            $this->getAllItemsCollection()->load();
        }
        return $this;
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
	
	
	public function getOrder($id){
		return $this->_myorderHelper->getOrderById($id);
	}
	
	public function formattedAddress($address){
        return $this->_myorderHelper->getFormattedAddress($address);
    }
	
	public function getAllItemsCollection(){
		$filterby = $this->getParemValuesFilterValues();
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
        $collection = $this->getAllItems();
		if($filterby == null){
		}else if($filterby == '1'){
			$collection->addFieldToFilter('status', 'delivered');
		}else if($filterby == '2'){
			$collection->addFieldToFilter('status', array('order_received','shipped','packed'));
		}else if($filterby == '3'){
			$collection->addFieldToFilter('status','returned');
		}else if($filterby == '4'){
			$collection->addFieldToFilter('status','cancelled');	
		}else if($filterby == '5'){
			$collection->addFieldToFilter('status','disputes');
		}
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
		$collection->setOrder('orderupdate_id','DESC');
        return $collection;
	}
	
	public function getParemValuesFilterValues(){
		return $this->getRequest()->getParam('filterby');
	}
	
	public function getPagerHtml(){
        return $this->getChildHtml('pager');
    }
	
	public function getItemByDetails($itemid){
		return $this->_myorderHelper->getOrderItem($itemid);
	}
	
	public function getButton($itemId){
		return $this->_myorderHelper->setButton($itemId);
	}
}
