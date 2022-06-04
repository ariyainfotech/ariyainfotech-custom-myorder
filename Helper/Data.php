<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\MyOrder\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Sales\Model\Order\Address;
use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Sales\Model\Order\Address\Renderer as AddressRenderer;
use Magento\Sales\Api\Data\ShipmentInterface;
use Magento\Sales\Api\Data\ShipmentTrackInterface;
use Magento\Sales\Api\ShipmentRepositoryInterface;

class Data extends AbstractHelper
{
	
	/**
     * @var CollectionFactory
     */
    protected $_orderCollectionFactory;
	
	/**
     * @var customerSession
     */
	protected $_customerSession;
	
	private $logger;
	
	protected $_priceHelper;
	
	protected $timezone;
	
	protected $_orderRepository;
	
	protected $_imagesHelper;
	
	protected $_orderRepositoryInterface;
	
	protected $addressRenderer;
	
	protected $paymentHelper;
	
	protected $_orderUpdateModel;
	
	protected $_orderUpdateCollection;
	
	protected $_orderUpdateFacetory;
	
	protected $_orderItemRepository;
	
    private $shipmentRepository;
	
	protected $_storeManager;
	
	protected $scopeConfig;
	
	protected $_productloader;
	
	protected $_approvalHelper;
	
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
		CollectionFactory $orderCollectionFactory,
		\Magento\Customer\Model\Session $customerSession,
		\Psr\Log\LoggerInterface $logger,
		\Magento\Framework\Pricing\Helper\Data $priceHelper,
		\Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
		\Magento\Sales\Api\OrderRepositoryInterface $orderRepositoryInterface,
		\Magento\Sales\Model\OrderRepository $orderRepository,
		\Magento\Catalog\Helper\Image $imagesHelper,
		PaymentHelper $paymentHelper,
        AddressRenderer $addressRenderer,
		\AriyaInfoTech\MyOrder\Model\OrderUpdate $orderUpdateModel,
		\AriyaInfoTech\MyOrder\Model\OrderUpdateFactory $orderUpdateFacetory,
		\AriyaInfoTech\MyOrder\Model\ResourceModel\OrderUpdate\CollectionFactory $orderUpdateCollection,
		\Magento\Sales\Api\OrderItemRepositoryInterface $orderItemRepository,
		\Magento\Catalog\Model\ProductFactory $productloader,
		ShipmentRepositoryInterface $shipmentRepository,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Helper\Context $context,
		\AriyaInfoTech\ApprovalRequester\Helper\Data $approvalHelper
    ) {
		$this->_orderCollectionFactory = $orderCollectionFactory;
		$this->_customerSession = $customerSession;
		$this->_timezone = $timezone;
		$this->_priceHelper = $priceHelper;
		$this->logger = $logger;
		$this->_orderRepository = $orderRepository;
		$this->_imagesHelper = $imagesHelper;
		$this->_orderRepositoryInterface = $orderRepositoryInterface;
		$this->addressRenderer = $addressRenderer;
        $this->paymentHelper = $paymentHelper;
		$this->_orderUpdateModel = $orderUpdateModel;
		$this->_orderUpdateFacetory = $orderUpdateFacetory;
		$this->_orderUpdateCollection = $orderUpdateCollection;
		$this->shipmentRepository = $shipmentRepository;
		$this->_orderItemRepository = $orderItemRepository;
		$this->scopeConfig = $scopeConfig;
		$this->_storeManager = $storeManager;
		$this->_productloader = $productloader;
		$this->_approvalHelper = $approvalHelper;
        parent::__construct($context);
    }
	
    /**
     * @return bool
     */
    public function isEnabled()
    {
        return true;
    }
	
	public function logCreate($message){
		$this->logger->critical($message);
	}
	
	/* 
	* This Function using test
	*/
	public function isCallHelper(){
		return "yes";
	}
	
	public function getLoadProduct($id){
		try{
			return $this->_productloader->create()->load($id);
		}catch(\Exception $e){
			$this->_logger->critical($e->getMessage());
			return false;
		}	
    }
	
	public function insertRecored($data){
		try{
			$this->_orderUpdateModel->SetData($data);
			$this->_orderUpdateModel->Save();
			return true;
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}	
	}	
	public function getProductImages($productid){
		try {
			$products = $this->getLoadProduct($productid);
			return $this->_imagesHelper->init($products, 'small_image', ['type'=>'small_image'])->keepAspectRatio(true)->resize('135','135')->getUrl();
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}	
	}
	
	/* get order Item collection */
    public function getOrderItem($itemId){
		try {
			$itemCollection = $this->_orderItemRepository->get($itemId);
			return $itemCollection;
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}	
    }
	
	/**
	 * @return array
	**/ 
	public function getCustomerOrder(){
		try {
			$customerId = $this->getCustomerId();
			return $this->_orderCollectionFactory->create()->addFieldToFilter('customer_id', $customerId);
			//$customerOrder = $this->_orderCollectionFactory->create()->addFieldToFilter('customer_id', $customerId);
			//return $customerOrder->getData();
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}
	}
	
	public function getItemCollection(){
		try{
			return $this->_orderUpdateCollection->create();
		}catch(\Exception $e){	
			$this->logger->critical($e->getMessage());
			return false;
		}	
	}
	
	public function getCustomerId(){
		try {	
			return $this->_customerSession->getCustomer()->getId();
		} catch (\Exception $e) {
			$this->logger->critical($e->getMessage());
			return false;
		}	
	}
	
	public function setPriceFormate($price){
		try {
			return $this->_priceHelper->currency($price, true, false);	
		}catch(\Exception $e){	
			$this->logger->critical($e->getMessage());
			return false;
		}
	}
	
	public function setDateFormate($date){
		try {
			return $this->_timezone->date(new \DateTime($date))->format('d M Y');
		}catch(\Exception $e){	
			$this->logger->critical($e->getMessage());
			return false;
		}
	}
	
	public function getOrderById($orderId){
		try {
			return $order = $this->_orderRepository->get($orderId);
		}catch(\Exception $e){	
			$this->logger->critical($e->getMessage());
			return false;
		}	
	}
	
	public function getFormattedAddress(Address $address){
        return $this->addressRenderer->format($address, 'html');
    }
	
	public function getItemColectionByCustomerId(){
		try{
			$customerId = $this->getCustomerId();
			return $this->_orderUpdateCollection->create()->addFieldToFilter('customer_id', $customerId);
		}catch(\Exception $e){	
			$this->logger->critical($e->getMessage());
			return false;
		}	
	}
	
	public function getItemIdToDetails($itemid){
		try{
			return $this->_orderUpdateFacetory->create()->load($itemid,'order_item_id');
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}	
	}
	
	public function getOrderIdWiseCollection($orderid){
		try{
			return $this->_orderUpdateFacetory->create()->load($orderid,'order_id');
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}
	}
	
	public function getStatusName($statusid){
		try{
			$statusvalue = 'Unknown Status';
			if($statusid == 'order_received'){
				$statusvalue = 'Order Received';
			}else if($statusid == 'packed'){
				$statusvalue = 'Item Packed';
			}else if($statusid == 'shipped'){
				$statusvalue = 'Item Shipped';	
			}else if($statusid == 'delivered'){	
				$statusvalue = 'Item Delivered';	
			}else if($statusid == 'returned'){
				$statusvalue = 'Returned';	
			}else if($statusid == 'cancelled'){
				$statusvalue = 'Cancelled';		
			}else if($statusid == 'disputes'){
				$statusvalue = 'Disputes';	
			}else if($statusid == 'return_request'){
				$statusvalue = 'Return Request';		
			}else if($statusid == 'dispute_opened'){	
				$statusvalue = 'Dispute Opened';
			}else{
				$statusvalue = 'Unknown Status';
			}
			return $statusvalue;
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}
	}
	
	public function getAallOrderCount(){
		try{
			$allorder = $this->getCustomerOrder();	
			return count($allorder);
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}	
	}
	
	public function getPendingOrderCount(){
		try{
			$pending = $this->getCustomerOrder();	
			$pending->addFieldToFilter('status','pending');
			return count($pending);
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}
	}
	
	public function getProcessingOrderCount(){
		try{
			$processing = $this->getCustomerOrder();	
			$processing->addFieldToFilter('status','processing');
			return count($processing);
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}
	}
	
	public function getCompleteOrderCount(){
		try{
			$complete = $this->getCustomerOrder();	
			$complete->addFieldToFilter('status','complete');
			return count($complete);
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}
	}
	
	public function getCanceledOrderCount(){
		try{
			$canceled = $this->getCustomerOrder();	
			$canceled->addFieldToFilter('status','canceled');
			return count($canceled);
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}
	}
	
	public function getClosedOrderCount(){
		try{
			$closed = $this->getCustomerOrder();	
			$closed->addFieldToFilter('status','closed');
			return count($closed);
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}
	}
	
	public function getDeliveredOrderCount(){
		try{
			$delivered = $this->getCustomerOrder();	
			$delivered->addFieldToFilter('status','delivered');
			return count($delivered);
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}
	}
	
	/**
     * Get Shipment Trackig data by Shipment Id
     *
     * @param $id
     *
     * @return ShipmentTrackInterface|null
     */
    public function getTracking($id){
		try{
			$shipment = $this->getShipmentById($id);

			if ($shipment) {
				return $shipment->getTracks();
			}
			return null;
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}	
    }

    /**
     * Get Shipment data by Shipment Id
     *
     * @param $id
     *
     * @return ShipmentInterface|null
     */
    public function getShipmentById($id){
        try {
            $shipment = $this->shipmentRepository->get($id);
			return $shipment;
        }catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
        }
    }
	
	public function getBaseUrl(){
		return $this->_storeManager->getStore()->getBaseUrl();
	}
	
	public function setButton($itemId){
		try{
			//o = no;
			//1 = yes;
			$buttonurl = '';
			$url = $this->getBaseUrl();
			$trturntypebt = 0;
			$returndata.= '';
			$items = $this->getItemIdToDetails($itemId);
			$itemdetails = $this->getOrderItem($itemId);
			
			if($itemdetails->getProductType() == 'amgiftcard'){
				return $returndata.= __('Order Received');	
			}
			
			if($items->getStatus() == 'order_received' || $items->getStatus() == 'packed'){
				if($this->isEnabelCancel()){
					$buttonurl = $url.'sale/myorder/itemcancel/order/'.$items->getOrderId().'/item/'.$itemId;
					$trturntypebt = 1;
					$returndata.="<a class='item-link' href='";
					$returndata.=$buttonurl;
					$returndata.="'>";
					$returndata.= __('Cancel Item');
					$returndata.="</a>";
				}else{
					$returndata.= $items->getStatus();	
				}
			}else if($items->getStatus() == 'shipped'){
				if($items->getShippedDate() != null){
					if($this->isEnabelDispute()):
						$days = $this->isDisputeDays();
						$shipdate = $items->getShippedDate();
						$today = date('Y-m-d');
						$dateone = date('Y-m-d', strtotime($shipdate));
						$datesecond = date('Y-m-d', strtotime($today));
						$difrent = $this->dateDiffInDays($dateone,$datesecond);
						if($days < $difrent){
							$buttonurl = $url.'sale/myorder/opendispute/order/'.$items->getOrderId().'/item/'.$itemId;
							$trturntypebt = 1;
							$returndata.="<a class='item-link' href='";
							$returndata.=$buttonurl;
							$returndata.="'>";
							$returndata.= __('Open Dispute');
							$returndata.="</a>";
						}else{
							$returndata.= __('Shipped Item');	
						}
					else:
						$returndata.= __('Shipped Item');	
					endif;	
				}else{
					$returndata.= __('Shipped Item');	
				}
			}else if($items->getStatus() == 'delivered'){
				if($this->isEnabelReturn()){
					if($items->getDeliveredDate() != null){
						$days = $this->isReturnDays();
						$returndate = $items->getShippedDate();
						$today = date('Y-m-d');
						$dateone = date('Y-m-d', strtotime($returndate));
						$datesecond = date('Y-m-d', strtotime($today));
						$difrent = $this->dateDiffInDays($dateone,$datesecond);
						if($days > $difrent){
							$buttonurl = $url.'sale/myorder/itemreturn/order/'.$items->getOrderId().'/item/'.$itemId;
							$trturntypebt = 1;
							$returndata.="<a class='item-link' href='";
							$returndata.=$buttonurl;
							$returndata.="'>";
							$returndata.= __('Return Item');
							$returndata.="</a>";
						}else{
							$returndata.= __('Delivered');
						}	
					}else{
						$returndata.= __('Delivered');
					}	
				}else{
					$returndata.= __('Delivered');
				}
			}else if($items->getStatus() == 'cancelled'){
				$returndata.= __('Cancelled Item');
			}else if($items->getStatus() == 'return_request'){
				$returndata.= __('Return Request');
			}else if($items->getStatus() == 'returned'){
				$returndata.= __('Returned Item');
			}else if($items->getStatus() == 'dispute_opened'){ 
				$returndata.= __('Dispute Opened');
			}else{
				$returndata.= __('Unknown Status');
			}
			return $returndata;
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
		}	
	}
	
	public function isEnabelReturn(){
		return $this->getConfig("myorder/general/return_enabled");
	}
	
	public function isReturnDays(){
		return $this->getConfig("myorder/general/return_days");
	}
	
	public function isEnabelDispute(){
		return $this->getConfig("myorder/general/dispute_enabled");
	}
	
	public function isDisputeDays(){
		return $this->getConfig("myorder/general/dispute_days");
	}
	
	public function isEnabelCancel(){
		return $this->getConfig("myorder/general/cancel_enabled");
	}
	
	public function getConfig($config_path){
		try{
			return $this->scopeConfig->getValue($config_path,\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}	
	}
	
	public function dateDiffInDays($date1, $date2){	
		try{
			$diff = strtotime($date2) - strtotime($date1); 
			return abs(round($diff / 86400)); 
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}	
	}
	
	public function getApprovalEmaildsByOrderid($oredrid){
		try{
			$request = $this->_approvalHelper->getRequestDetailsFactory()->create()->load($oredrid,"order_id");
			$approvalid = array();
			if($request->getRequestApprovedid() != null){
				$approvalid = explode(",",$request->getRequestApprovedid());
			}
			$returnemail = array();
			if(sizeof($approvalid) > 0){
				foreach($approvalid as $key=>$value){
					$returnemail[]=$this->_approvalHelper->getCustomerIdToEmailId($value);
				}
			}
			return $returnemail;
		}catch(\Exception $e){
			$this->logger->critical($e->getMessage());
			return false;
		}
	}
	
	public function isRequesterAccount(){
		if($this->_customerSession->isLoggedIn()){
			$accountType = $this->_customerSession->getCustomer()->getAccountType();
			if($accountType == 'is_requester'){
				return true;
			}
			return false;
		}
		return false;
	}
	
	
}

