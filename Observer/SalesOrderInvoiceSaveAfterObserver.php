<?php

namespace Ariya\MyOrder\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Session\SessionManager;
use Magento\Quote\Model\QuoteRepository;

class SalesOrderInvoiceSaveAfterObserver implements ObserverInterface
{
	 /**
     * @var eventManager
     */
    protected $_eventManager;

    /**
     * @var Magento\Customer\Model\Session
     */
    protected $_coreSession;

    /**
     * @var QuoteRepository
     */
    protected $_quoteRepository;
	
	protected $_myorderhelper;
	
	public function __construct(
        \Magento\Framework\Event\Manager $eventManager,
        SessionManager $coreSession,
        QuoteRepository $quoteRepository,
		\Ariya\MyOrder\Helper\Data $myorderhelper
	) {
        $this->_eventManager = $eventManager;
		$this->_coreSession = $coreSession;
        $this->_quoteRepository = $quoteRepository;
		$this->_myorderhelper = $myorderhelper;
	}		
	
	public function execute(\Magento\Framework\Event\Observer $observer){
		try{
			$event = $observer->getInvoice();
			$invoice = $observer->getEvent()->getInvoice();
			$invoiceId = $observer->getInvoice()->getId();
			$invoiceIncrementId = $observer->getInvoice()->getIncrementId();
			$order = $observer->getInvoice()->getOrder();
			$lastOrderId = $order->getId();
			$items = $invoice->getItems();
			/*echo "<pre>";
			foreach ($items as $value) {
				echo "<br/>";
				echo $value->getOrderItemId();
			}
			print_r($items->getData());
			exit;*/
			foreach($items as $itemc):
				if($itemc->getQty() != 0):
					$itemCollection = $this->_myorderhelper->getItemCollection();
					$itemCollection->addFieldToFilter("order_item_id",$itemc->getOrderItemId());
					foreach($itemCollection as $item):
						$item->setInvoiceId($invoiceId);
						$item->setInvoiceIncrementId($invoiceIncrementId);
						$item->save();
					endforeach;
				endif;
			endforeach;
		}catch(\Exception $e){
			$this->_myorderhelper->logCreate($e->getMessage());
		}
		return $this;
	}
}