<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\MyOrder\Model;

use Magento\Framework\Api\DataObjectHelper;
use AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface;
use AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterfaceFactory;

class OrderUpdate extends \Magento\Framework\Model\AbstractModel
{

    protected $_eventPrefix = 'AriyaInfoTech_MyOrder_orderupdate';
    protected $orderupdateDataFactory;

    protected $dataObjectHelper;


    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param OrderUpdateInterfaceFactory $orderupdateDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \AriyaInfoTech\MyOrder\Model\ResourceModel\OrderUpdate $resource
     * @param \AriyaInfoTech\MyOrder\Model\ResourceModel\OrderUpdate\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        OrderUpdateInterfaceFactory $orderupdateDataFactory,
        DataObjectHelper $dataObjectHelper,
        \AriyaInfoTech\MyOrder\Model\ResourceModel\OrderUpdate $resource,
        \AriyaInfoTech\MyOrder\Model\ResourceModel\OrderUpdate\Collection $resourceCollection,
        array $data = []
    ) {
        $this->orderupdateDataFactory = $orderupdateDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve orderupdate model with orderupdate data
     * @return OrderUpdateInterface
     */
    public function getDataModel()
    {
        $orderupdateData = $this->getData();
        
        $orderupdateDataObject = $this->orderupdateDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $orderupdateDataObject,
            $orderupdateData,
            OrderUpdateInterface::class
        );
        
        return $orderupdateDataObject;
    }
}

