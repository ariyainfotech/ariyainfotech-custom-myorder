<?php

namespace AriyaInfoTech\MyOrder\Observer;

use Magento\Framework\Event\ObserverInterface;

class SalesOrderShipmentSaveAfterObserver implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
		try{	
			$shipment = $observer->getEvent()->getShipment();
			$shipmentId = $shipment->getId();
			$shipmentIncId = $shipment->getIncrementId();
			$shipmentDate = $shipment->getCreatedAt();
			/** @var \Magento\Sales\Model\Order $order */
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$myOrderhelper = $objectManager->get('\AriyaInfoTech\MyOrder\Helper\Data');
			foreach ($shipment->getItemsCollection() as $item) { 
				$itemCollection = $myOrderhelper->getItemCollection();
				$itemCollection->addFieldToFilter("order_item_id",$item->getOrderItemId());
				
				foreach($itemCollection as $items){
					$items->setStatus('shipped');
					$items->setShipmentId($shipmentId);
					$items->setShipmentIncrementId($shipmentIncId);
					$items->setShippedDate($shipmentDate);
					$items->save();
				}
			}
			return $this;
		}catch(\Exception $e){
		    return $this;
	    }	
        return $this;
    }
}