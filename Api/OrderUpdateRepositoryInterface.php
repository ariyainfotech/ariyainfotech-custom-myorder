<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\MyOrder\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface OrderUpdateRepositoryInterface
{

    /**
     * Save OrderUpdate
     * @param \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface $orderUpdate
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface $orderUpdate
    );

    /**
     * Retrieve OrderUpdate
     * @param string $orderupdateId
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($orderupdateId);

    /**
     * Retrieve OrderUpdate matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete OrderUpdate
     * @param \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface $orderUpdate
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface $orderUpdate
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

