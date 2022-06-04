<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ariya\MyOrder\Block\Myorder;

class Details extends \Magento\Framework\View\Element\Template
{
	
	protected $_myorderHelper;
	
	 /**
     * Associated array of totals
     * array(
     *  $totalCode => $totalObject
     * )
     *
     * @var array
     */
    protected $_totals;

    /**
     * @var Order|null
     */
    protected $_order = null;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

	protected $_gstHelper;
	
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
		\Ariya\MyOrder\Helper\Data $myorderHelper,
		\Magento\Framework\Registry $registry,
		\Magento\Framework\App\ResourceConnection $resource,
		\Codilar\Gst\Helper\Data $gstHelper,
        array $data = []
    ) {
		$this->_myorderHelper = $myorderHelper;
		$this->_coreRegistry = $registry;
		$this->_resource = $resource;
		$this->_gstHelper = $gstHelper;
        parent::__construct($context, $data);
    }
	
	public function orderById(){
		$orderid = $this->getOrderId();
		return $this->_myorderHelper->getOrderById($orderid);
	}
	
	public function getOrderId(){
		return $this->getRequest()->getParam('order_id');	
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
	
	public function formattedAddress($address){
        return $this->_myorderHelper->getFormattedAddress($address);
    }
	
	/**
     * Initialize self totals and children blocks totals before html building
     *
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->_initTotals();
        foreach ($this->getLayout()->getChildBlocks($this->getNameInLayout()) as $child) {
            if (method_exists($child, 'initTotals') && is_callable([$child, 'initTotals'])) {
                $child->initTotals();
            }
        }
        return parent::_beforeToHtml();
    }

    /**
     * Get order object
     *
     * @return Order
     */
    public function getOrder(){
		$orderid = $this->getOrderId();
		$this->_order  = $this->_myorderHelper->getOrderById($orderid);
		return $this->_order;
        
    }

    /**
     * Sets order.
     *
     * @param Order $order
     * @return $this
     */
    public function setOrder($order){
        $this->_order = $order;
        return $this;
    }

    /**
     * Get totals source object
     *
     * @return Order
     */
    public function getSource()
    {
        return $this->getOrder();
    }

    /**
     * Initialize order totals array
     *
     * @return $this
     */
    protected function _initTotals()
    {
        $source = $this->getSource();

        $this->_totals = [];
        $this->_totals['subtotal'] = new \Magento\Framework\DataObject(
            ['code' => 'subtotal', 'value' => $source->getSubtotal(), 'label' => __('Subtotal')]
        );

        /**
         * Add discount
         */
        if ((double)$this->getSource()->getDiscountAmount() != 0) {
            if ($this->getSource()->getDiscountDescription()) {
                $discountLabel = __('Discount (%1)', $source->getDiscountDescription());
            } else {
                $discountLabel = __('Discount');
            }
            $this->_totals['discount'] = new \Magento\Framework\DataObject(
                [
                    'code' => 'discount',
                    'field' => 'discount_amount',
                    'value' => $source->getDiscountAmount(),
                    'label' => $discountLabel,
                ]
            );
        }
		
		/**
		Tax Add
		**/
		if ((double)$this->getSource()->getTaxAmount() != 0) {
            if ($this->getSource()->getTaxAmount()) {
                $discountLabel = __('GST', $source->getDiscountDescription());
            }
            $this->_totals['tax_amount'] = new \Magento\Framework\DataObject(
                [
                    'code' => 'tax_amount',
                    'field' => 'tax_amount',
                    'value' => $source->getTaxAmount(),
                    'label' => $discountLabel,
                ]
            );
        }

        /**
         * Add shipping
         */
        if (!$source->getIsVirtual() && ((double)$source->getShippingAmount() || $source->getShippingDescription())) {
            $label = __('Shipping & Handling');
            if ($this->getSource()->getCouponCode() && !isset($this->_totals['discount'])) {
                $label = __('Shipping & Handling (%1)', $this->getSource()->getCouponCode());
            }

            $this->_totals['shipping'] = new \Magento\Framework\DataObject(
                [
                    'code' => 'shipping',
                    'field' => 'shipping_amount',
                    'value' => $this->getSource()->getShippingAmount(),
                    'label' => $label,
                ]
            );
        }

        $this->_totals['grand_total'] = new \Magento\Framework\DataObject(
            [
                'code' => 'grand_total',
                'field' => 'grand_total',
                'strong' => true,
                'value' => $source->getGrandTotal(),
                'label' => __('Total Amount'),
            ]
        );

        /**
         * Base grandtotal
         */
        if ($this->getOrder()->isCurrencyDifferent()) {
            $this->_totals['base_grandtotal'] = new \Magento\Framework\DataObject(
                [
                    'code' => 'base_grandtotal',
                    'value' => $this->getOrder()->formatBasePrice($source->getBaseGrandTotal()),
                    'label' => __('Grand Total to be Charged'),
                    'is_formated' => true,
                ]
            );
        }
        return $this;
    }

    /**
     * Add new total to totals array after specific total or before last total by default
     *
     * @param   \Magento\Framework\DataObject $total
     * @param   null|string $after
     * @return  $this
     */
    public function addTotal(\Magento\Framework\DataObject $total, $after = null)
    {
        if ($after !== null && $after != 'last' && $after != 'first') {
            $totals = [];
            $added = false;
            foreach ($this->_totals as $code => $item) {
                $totals[$code] = $item;
                if ($code == $after) {
                    $added = true;
                    $totals[$total->getCode()] = $total;
                }
            }
            if (!$added) {
                $last = array_pop($totals);
                $totals[$total->getCode()] = $total;
                $totals[$last->getCode()] = $last;
            }
            $this->_totals = $totals;
        } elseif ($after == 'last') {
            $this->_totals[$total->getCode()] = $total;
        } elseif ($after == 'first') {
            $totals = [$total->getCode() => $total];
            $this->_totals = array_merge($totals, $this->_totals);
        } else {
            $last = array_pop($this->_totals);
            $this->_totals[$total->getCode()] = $total;
            $this->_totals[$last->getCode()] = $last;
        }
        return $this;
    }

    /**
     * Add new total to totals array before specific total or after first total by default
     *
     * @param   \Magento\Framework\DataObject $total
     * @param   null|string $before
     * @return  $this
     */
    public function addTotalBefore(\Magento\Framework\DataObject $total, $before = null)
    {
        if ($before !== null) {
            if (!is_array($before)) {
                $before = [$before];
            }
            foreach ($before as $beforeTotals) {
                if (isset($this->_totals[$beforeTotals])) {
                    $totals = [];
                    foreach ($this->_totals as $code => $item) {
                        if ($code == $beforeTotals) {
                            $totals[$total->getCode()] = $total;
                        }
                        $totals[$code] = $item;
                    }
                    $this->_totals = $totals;
                    return $this;
                }
            }
        }
        $totals = [];
        $first = array_shift($this->_totals);
        $totals[$first->getCode()] = $first;
        $totals[$total->getCode()] = $total;
        foreach ($this->_totals as $code => $item) {
            $totals[$code] = $item;
        }
        $this->_totals = $totals;
        return $this;
    }

    /**
     * Get Total object by code
     *
     * @param string $code
     * @return mixed
     */
    public function getTotal($code)
    {
        if (isset($this->_totals[$code])) {
            return $this->_totals[$code];
        }
        return false;
    }

    /**
     * Delete total by specific
     *
     * @param   string $code
     * @return  $this
     */
    public function removeTotal($code)
    {
        unset($this->_totals[$code]);
        return $this;
    }

    /**
     * Apply sort orders to totals array.
     * Array should have next structure
     * array(
     *  $totalCode => $totalSortOrder
     * )
     *
     * @param   array $order
     * @return  $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function applySortOrder($order)
    {
        \uksort(
            $this->_totals,
            function ($code1, $code2) use ($order) {
                return ($order[$code1] ?? 0) <=> ($order[$code2] ?? 0);
            }
        );
        return $this;
    }

    /**
     * Get totals array for visualization
     *
     * @param array|null $area
     * @return array
     */
    public function getTotals($area = null)
    {
        $totals = [];
        if ($area === null) {
            $totals = $this->_totals;
        } else {
            $area = (string)$area;
            foreach ($this->_totals as $total) {
                $totalArea = (string)$total->getArea();
                if ($totalArea == $area) {
                    $totals[] = $total;
                }
            }
        }
        return $totals;
    }

    /**
     * Format total value based on order currency
     *
     * @param   \Magento\Framework\DataObject $total
     * @return  string
     */
    public function formatValue($total)
    {
        if (!$total->getIsFormated()) {
            return $this->getOrder()->formatPrice($total->getValue());
        }
        return $total->getValue();
    }
	
	public function getButton($itemId){
		return $this->_myorderHelper->setButton($itemId);
	}
	
	public function getGstCollection($totalGst){
		try{
			$gstCollection = array();
			$order = $this->getOrder();	
			$productionState = $this->_gstHelper->getProductionState();
			$shippingGstStatus = $this->_gstHelper->getShippingGstStatus();
			$productionState = str_replace(' ', '', strtolower($productionState));
			$state = $order->getShippingAddress()->getRegion();
			$state = str_replace(' ', '', strtolower($state));
			$shippingTaxAmount = $order->getShippingTaxAmount();
			$sgst = $totalGst/2;
			$igst = $totalGst;
			if($state==$productionState){
				$state_title = "SGST";
				$central_title = "CGST";
				$gstCollection[1]['code'] = 'sgst';
				$gstCollection[1]['label'] = $state_title;
				$gstCollection[1]['amount'] = $sgst;
				$gstCollection[2]['code'] = 'cgst';
				$gstCollection[2]['label'] = $central_title;
				$gstCollection[2]['amount'] = $sgst;
			}else{
				$title = "IGST";
				$gstCollection[1]['code'] = 'igst';
				$gstCollection[1]['label'] = $title;
				$gstCollection[1]['amount'] = $igst;
			}
			$gstCollection[0]['code'] = 'total_gst';
			$gstCollection[0]['label'] = 'Total GST';
			$gstCollection[0]['amount'] = $totalGst;
			return $gstCollection;
		}catch(\Exception $e) {
			return false;
		}	
	}
	
	public function getApprovedEmailds(){
		try{
			$orderid = $this->getOrderId();
			return $this->_myorderHelper->getApprovalEmaildsByOrderid($orderid );
		}catch(\Exception $e) {
			return false;
		}
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

