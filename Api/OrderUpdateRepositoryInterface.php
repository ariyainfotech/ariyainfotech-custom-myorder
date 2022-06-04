<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ariya\MyOrder\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface OrderUpdateRepositoryInterface
{

    /**
     * Save OrderUpdate
     * @param \Ariya\MyOrder\Api\Data\OrderUpdateInterface $orderUpdate
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Ariya\MyOrder\Api\Data\OrderUpdateInterface $orderUpdate
    );

    /**
     * Retrieve OrderUpdate
     * @param string $orderupdateId
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($orderupdateId);

    /**
     * Retrieve OrderUpdate matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Ariya\MyOrder\Api\Data\OrderUpdateSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete OrderUpdate
     * @param \Ariya\MyOrder\Api\Data\OrderUpdateInterface $orderUpdate
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Ariya\MyOrder\Api\Data\OrderUpdateInterface $orderUpdate
    );

    /**
     * Delete OrderUpdate by ID
     * @param string $orderupdateId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($orderupdateId);
}

