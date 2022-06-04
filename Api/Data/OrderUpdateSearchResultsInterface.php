<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\MyOrder\Api\Data;

interface OrderUpdateSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get OrderUpdate list.
     * @return \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface[]
     */
    public function getItems();

    /**
     * Set id list.
     * @param \AriyaInfoTech\MyOrder\Api\Data\OrderUpdateInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

