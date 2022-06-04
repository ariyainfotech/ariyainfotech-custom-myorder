<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\MyOrder\Model\Data;

use AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface;

class OrderUpdate extends \Magento\Framework\Api\AbstractExtensibleObject implements OrderUpdateInterface
{

    /**
     * Get orderupdate_id
     * @return string|null
     */
    public function getOrderupdateId()
    {
        return $this->_get(self::ORDERUPDATE_ID);
    }

    /**
     * Set orderupdate_id
     * @param string $orderupdateId
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setOrderupdateId($orderupdateId)
    {
        return $this->setData(self::ORDERUPDATE_ID, $orderupdateId);
    }

    /**
     * Get id
     * @return string|null
     */
    public function getId()
    {
        return $this->_get(self::ID);
    }

    /**
     * Set id
     * @param string $id
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get seller_id
     * @return string|null
     */
    public function getSellerId()
    {
        return $this->_get(self::SELLER_ID);
    }

    /**
     * Set seller_id
     * @param string $sellerId
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setSellerId($sellerId)
    {
        return $this->setData(self::SELLER_ID, $sellerId);
    }

    /**
     * Get order_id
     * @return string|null
     */
    public function getOrderId()
    {
        return $this->_get(self::ORDER_ID);
    }

    /**
     * Set order_id
     * @param string $orderId
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * Get order_increment_id
     * @return string|null
     */
    public function getOrderIncrementId()
    {
        return $this->_get(self::ORDER_INCREMENT_ID);
    }

    /**
     * Set order_increment_id
     * @param string $orderIncrementId
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setOrderIncrementId($orderIncrementId)
    {
        return $this->setData(self::ORDER_INCREMENT_ID, $orderIncrementId);
    }

    /**
     * Get order_item_id
     * @return string|null
     */
    public function getOrderItemId()
    {
        return $this->_get(self::ORDER_ITEM_ID);
    }

    /**
     * Set order_item_id
     * @param string $orderItemId
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setOrderItemId($orderItemId)
    {
        return $this->setData(self::ORDER_ITEM_ID, $orderItemId);
    }

    /**
     * Get invoice_id
     * @return string|null
     */
    public function getInvoiceId()
    {
        return $this->_get(self::INVOICE_ID);
    }

    /**
     * Set invoice_id
     * @param string $invoiceId
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setInvoiceId($invoiceId)
    {
        return $this->setData(self::INVOICE_ID, $invoiceId);
    }

    /**
     * Get invoice_increment_id
     * @return string|null
     */
    public function getInvoiceIncrementId()
    {
        return $this->_get(self::INVOICE_INCREMENT_ID);
    }

    /**
     * Set invoice_increment_id
     * @param string $invoiceIncrementId
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setInvoiceIncrementId($invoiceIncrementId)
    {
        return $this->setData(self::INVOICE_INCREMENT_ID, $invoiceIncrementId);
    }

    /**
     * Get creditmemo_id
     * @return string|null
     */
    public function getCreditmemoId()
    {
        return $this->_get(self::CREDITMEMO_ID);
    }

    /**
     * Set creditmemo_id
     * @param string $creditmemoId
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setCreditmemoId($creditmemoId)
    {
        return $this->setData(self::CREDITMEMO_ID, $creditmemoId);
    }

    /**
     * Get creditmemo_increment_id
     * @return string|null
     */
    public function getCreditmemoIncrementId()
    {
        return $this->_get(self::CREDITMEMO_INCREMENT_ID);
    }

    /**
     * Set creditmemo_increment_id
     * @param string $creditmemoIncrementId
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setCreditmemoIncrementId($creditmemoIncrementId)
    {
        return $this->setData(self::CREDITMEMO_INCREMENT_ID, $creditmemoIncrementId);
    }

    /**
     * Get shipment_id
     * @return string|null
     */
    public function getShipmentId()
    {
        return $this->_get(self::SHIPMENT_ID);
    }

    /**
     * Set shipment_id
     * @param string $shipmentId
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setShipmentId($shipmentId)
    {
        return $this->setData(self::SHIPMENT_ID, $shipmentId);
    }

    /**
     * Get shipment_increment_id
     * @return string|null
     */
    public function getShipmentIncrementId()
    {
        return $this->_get(self::SHIPMENT_INCREMENT_ID);
    }

    /**
     * Set shipment_increment_id
     * @param string $shipmentIncrementId
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setShipmentIncrementId($shipmentIncrementId)
    {
        return $this->setData(self::SHIPMENT_INCREMENT_ID, $shipmentIncrementId);
    }

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    /**
     * Set customer_id
     * @param string $customerId
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }
}

