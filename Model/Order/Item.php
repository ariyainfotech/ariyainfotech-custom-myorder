<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AriyaInfoTech\MyOrder\Model\Order;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Sales\Model\AbstractModel;


/**
 * Order Item Model
 *
 * @api
 * @method int getGiftMessageId()
 * @method \Magento\Sales\Model\Order\Item setGiftMessagseId(int $value)
 * @method int getGiftMessageAvailable()
 * @method \Magento\Sales\Model\Order\Item setGiftMessageAvailable(int $value)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @since 100.0.2
 */
class Item extends \Magento\Sales\Model\Order\Item
{
	/**
     * Retrieve status
     *
     * @return string
     */
	 
	//protected $_myorderHelper;
	
	//public function __construct(\AriyaInfoTech\MyOrder\Helper\Data $myorderHelper) {
		//$this->_myorderHelper = $myorderHelper;
	//}
 
    public function getStatus(){
		$itemsttaus = $this->getCustomStatus();
		$itemId = $this->getItemId();
		$items='';
		$items.='';
		$items.="<div class='updates'><div>";
		$items.= $itemsttaus;
		$items.="</div>";
		if($this->getItemStatus() == 'order_received'){
			$items.="<div class='updatesttaus'><a data-id-update='packed' class='click-up' data-item-id='";
			$items.=$itemId;
			$items.="' href='#'><div>Action : packed</div></a></div>";	
		}else if($this->getItemStatus() == 'shipped'){
			$items.="<div class='updatesttaus'><a data-id-update='delivered' class='click-up' data-item-id='";
			$items.=$itemId;
			$items.="' href='#'><div>Action : delivered</div></a></div>";
		}else if($this->getItemStatus() == 'cancelled'){
			if($this->getCancelledReason() != null){
				$items.="<div class='cancle-reson'><strong>Reason: </strong>";
				$items.= $this->getCancelledReason();
				$items.="</div>";
			}
			if($this->getCancelledMessage() != null){
				$items.="<div class='cancle-message'><strong>Comment: </strong>";
				$items.= $this->getCancelledMessage();
				$items.="</div>";
			}
		}
		$items.="</div>";
        return $items;
    }
	
	public function getItemStatus(){
		$helper = $this->getMyOrderHelper();
		$itemData = $helper->getItemIdToDetails($this->getItemId());
		return $itemData->getStatus();
	}
	
	public function getCancelledReason(){
		$helper = $this->getMyOrderHelper();
		$itemData = $helper->getItemIdToDetails($this->getItemId());
		return $itemData->getCancelReason();
	}
	
	public function getCancelledMessage(){
		$helper = $this->getMyOrderHelper();
		$itemData = $helper->getItemIdToDetails($this->getItemId());
		return $itemData->getCancelMessage();
	}
	
	public function getCustomStatus(){
		$helper = $this->getMyOrderHelper();
		$itemData = $helper->getItemIdToDetails($this->getItemId());
		return $helper->getStatusName($itemData->getStatus());
	}
	
	public function getMyOrderHelper(){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		return $objectManager->get('\AriyaInfoTech\MyOrder\Helper\Data');
	}
	
	public function getItemDate(){
		$helper = $this->getMyOrderHelper();
		$itemData = $helper->getItemIdToDetails($this->getItemId());
		return $itemData->getOrderReceivedDate();
	}
	
	public function getItemPackedDate(){
		$helper = $this->getMyOrderHelper();
		$itemData = $helper->getItemIdToDetails($this->getItemId());
		return $itemData->getPackedDate();
	}
	
	public function getItemShippedDate(){
		$helper = $this->getMyOrderHelper();
		$itemData = $helper->getItemIdToDetails($this->getItemId());
		return $itemData->getShippedDate();
	}
	public function getShipmentIdDetails(){
		$helper = $this->getMyOrderHelper();
		$itemData = $helper->getItemIdToDetails($this->getItemId());
		return $itemData->getShipmentId();
	}
	public function getItemDeliveredDate(){
		$helper = $this->getMyOrderHelper();
		$itemData = $helper->getItemIdToDetails($this->getItemId());
		return $itemData->getDeliveredDate();
	}
}

