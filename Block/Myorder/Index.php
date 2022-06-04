<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\MyOrder\Block\Myorder;

class Index extends \Magento\Framework\View\Element\Template
{


	protected $_myorderHelper;
	protected $_resource;
	protected $connection;

	
    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
		\AriyaInfoTech\MyOrder\Helper\Data $myorderHelper,
		\Magento\Framework\App\ResourceConnection $resource,
        array $data = []
    ) {
		$this->_myorderHelper = $myorderHelper;
		$this->_resource = $resource;
        parent::__construct($context, $data);
    }
	
	protected function _prepareLayout(){
        parent::_prepareLayout();
        if ($this->getOredrCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'custom.history.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)->setCollection(
                    $this->getOredrCollection()
                );
            $this->setChild('pager', $pager);
            $this->getOredrCollection()->load();
        }
        return $this;
    }
	
	public function getAllOrders(){
		return $this->_myorderHelper->getCustomerOrder();
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
	
	public function getOredrCollection(){
		$filterby = $this->getParemValuesFilterValues();
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
        $collection = $this->getAllOrders();
		if($filterby == '1'){
			$collection->addFieldToFilter('status','pending');
		}else if($filterby == '2'){
			$collection->addFieldToFilter('status','processing');
		}else if($filterby == '3'){
			$collection->addFieldToFilter('status','complete');
		}else if($filterby == '4'){
			$collection->addFieldToFilter('status','canceled');
		}else if($filterby == '5'){
			$collection->addFieldToFilter('status','closed');
		}else if($filterby == '6'){
			$collection->addFieldToFilter('status','delivered');
		}
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
		$collection->setOrder('created_at','DESC');
        return $collection;
	}
	
	public function getShipmentDetails($shipid){
		return $this->_myorderHelper->getTracking($shipid);
	}
	
	public function getPagerHtml(){
        return $this->getChildHtml('pager');
    }
	
	public function formattedAddress($address){
        return $this->_myorderHelper->getFormattedAddress($address);
    }
	
	public function getOredrCounts(){
		return $this->_myorderHelper->getAallOrderCount();
	}
	
	public function getButton($itemId){
		return $this->_myorderHelper->setButton($itemId);
	}
	
	public function getOrderWiseCollection($orderid){
		return $this->_myorderHelper->getOrderIdWiseCollection($orderid);
	}
	
	public function getParemValuesFilterValues(){
		return $this->getRequest()->getParam('filterby');
	}
	
	public function isRequesterAc(){
		return $this->_myorderHelper->isRequesterAccount();
	}
	
	protected function getConnection()
    {
        if (!$this->connection) {
            $this->connection = $this->_resource->getConnection('core_write');
        }
        return $this->connection;
    }

    public function getReorderData($orderid)
    {
        $table=$this->_resource->getTableName('ariya_approvalrequester_requestdetails'); 
        $req_data = $this->getConnection()->fetchRow('SELECT requestdetails_id,quote_id FROM ' . $table.' WHERE order_id = '.$orderid);
        return $req_data;
    }
	
	
}