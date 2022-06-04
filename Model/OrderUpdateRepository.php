<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\MyOrder\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterfaceFactory;
use AriyaInfoTech\MyOrder\Api\Data\OrderUpdateSearchResultsInterfaceFactory;
use AriyaInfoTech\MyOrder\Api\OrderUpdateRepositoryInterface;
use AriyaInfoTech\MyOrder\Model\ResourceModel\OrderUpdate as ResourceOrderUpdate;
use AriyaInfoTech\MyOrder\Model\ResourceModel\OrderUpdate\CollectionFactory as OrderUpdateCollectionFactory;

class OrderUpdateRepository implements OrderUpdateRepositoryInterface
{

    protected $resource;

    protected $dataObjectHelper;

    protected $extensibleDataObjectConverter;
    protected $orderUpdateCollectionFactory;

    private $storeManager;

    protected $dataObjectProcessor;

    protected $dataOrderUpdateFactory;

    protected $searchResultsFactory;

    protected $orderUpdateFactory;

    private $collectionProcessor;

    protected $extensionAttributesJoinProcessor;


    /**
     * @param ResourceOrderUpdate $resource
     * @param OrderUpdateFactory $orderUpdateFactory
     * @param OrderUpdateInterfaceFactory $dataOrderUpdateFactory
     * @param OrderUpdateCollectionFactory $orderUpdateCollectionFactory
     * @param OrderUpdateSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceOrderUpdate $resource,
        OrderUpdateFactory $orderUpdateFactory,
        OrderUpdateInterfaceFactory $dataOrderUpdateFactory,
        OrderUpdateCollectionFactory $orderUpdateCollectionFactory,
        OrderUpdateSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->orderUpdateFactory = $orderUpdateFactory;
        $this->orderUpdateCollectionFactory = $orderUpdateCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataOrderUpdateFactory = $dataOrderUpdateFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface $orderUpdate
    ) {
        /* if (empty($orderUpdate->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $orderUpdate->setStoreId($storeId);
        } */
        
        $orderUpdateData = $this->extensibleDataObjectConverter->toNestedArray(
            $orderUpdate,
            [],
            \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface::class
        );
        
        $orderUpdateModel = $this->orderUpdateFactory->create()->setData($orderUpdateData);
        
        try {
            $this->resource->save($orderUpdateModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the orderUpdate: %1',
                $exception->getMessage()
            ));
        }
        return $orderUpdateModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($orderUpdateId)
    {
        $orderUpdate = $this->orderUpdateFactory->create();
        $this->resource->load($orderUpdate, $orderUpdateId);
        if (!$orderUpdate->getId()) {
            throw new NoSuchEntityException(__('OrderUpdate with id "%1" does not exist.', $orderUpdateId));
        }
        return $orderUpdate->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->orderUpdateCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface $orderUpdate
    ) {
        try {
            $orderUpdateModel = $this->orderUpdateFactory->create();
            $this->resource->load($orderUpdateModel, $orderUpdate->getOrderupdateId());
            $this->resource->delete($orderUpdateModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the OrderUpdate: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($orderUpdateId)
    {
        return $this->delete($this->get($orderUpdateId));
    }
}

