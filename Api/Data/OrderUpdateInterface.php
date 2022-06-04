<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ariya\MyOrder\Api\Data;

interface OrderUpdateInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const CUSTOMER_ID = 'customer_id';
    const SHIPMENT_ID = 'shipment_id';
    const INVOICE_INCREMENT_ID = 'invoice_increment_id';
    const CREDITMEMO_INCREMENT_ID = 'creditmemo_increment_id';
    const ORDER_ID = 'order_id';
    const ORDER_INCREMENT_ID = 'order_increment_id';
    const ORDER_ITEM_ID = 'order_item_id';
    const CREDITMEMO_ID = 'creditmemo_id';
    const SELLER_ID = 'seller_id';
    const ID = 'id';
    const SHIPMENT_INCREMENT_ID = 'shipment_increment_id';
    const ORDERUPDATE_ID = 'orderupdate_id';
    const INVOICE_ID = 'invoice_id';

    /**
     * Get orderupdate_id
     * @return string|null
     */
    public function getOrderupdateId();

    /**
     * Set orderupdate_id
     * @param string $orderupdateId
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setOrderupdateId($orderupdateId);

    /**
     * Get id
     * @return string|null
     */
    public function getId();

    /**
     * Set id
     * @param string $id
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setId($id);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Ariya\MyOrder\Api\Data\OrderUpdateExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Ariya\MyOrder\Api\Data\OrderUpdateExtensionInterface $extensionAttributes
    );

    /**
     * Get seller_id
     * @return string|null
     */
    public function getSellerId();

    /**
     * Set seller_id
     * @param string $sellerId
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setSellerId($sellerId);

    /**
     * Get order_id
     * @return string|null
     */
    public function getOrderId();

    /**
     * Set order_id
     * @param string $orderId
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setOrderId($orderId);

    /**
     * Get order_increment_id
     * @return string|null
     */
    public function getOrderIncrementId();

    /**
     * Set order_increment_id
     * @param string $orderIncrementId
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setOrderIncrementId($orderIncrementId);

    /**
     * Get order_item_id
     * @return string|null
     */
    public function getOrderItemId();

    /**
     * Set order_item_id
     * @param string $orderItemId
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setOrderItemId($orderItemId);

    /**
     * Get invoice_id
     * @return string|null
     */
    public function getInvoiceId();

    /**
     * Set invoice_id
     * @param string $invoiceId
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setInvoiceId($invoiceId);

    /**
     * Get invoice_increment_id
     * @return string|null
     */
    public function getInvoiceIncrementId();

    /**
     * Set invoice_increment_id
     * @param string $invoiceIncrementId
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setInvoiceIncrementId($invoiceIncrementId);

    /**
     * Get creditmemo_id
     * @return string|null
     */
    public function getCreditmemoId();

    /**
     * Set creditmemo_id
     * @param string $creditmemoId
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setCreditmemoId($creditmemoId);

    /**
     * Get creditmemo_increment_id
     * @return string|null
     */
    public function getCreditmemoIncrementId();

    /**
     * Set creditmemo_increment_id
     * @param string $creditmemoIncrementId
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setCreditmemoIncrementId($creditmemoIncrementId);

    /**
     * Get shipment_id
     * @return string|null
     */
    public function getShipmentId();

    /**
     * Set shipment_id
     * @param string $shipmentId
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setShipmentId($shipmentId);

    /**
     * Get shipment_increment_id
     * @return string|null
     */
    public function getShipmentIncrementId();

    /**
     * Set shipment_increment_id
     * @param string $shipmentIncrementId
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setShipmentIncrementId($shipmentIncrementId);

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     * @param string $customerId
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setCustomerId($customerId);
}

