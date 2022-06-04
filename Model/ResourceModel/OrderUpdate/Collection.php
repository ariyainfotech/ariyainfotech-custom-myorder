<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace AriyaInfoTech\MyOrder\Model\ResourceModel\OrderUpdate;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'orderupdate_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \AriyaInfoTech\MyOrder\Model\OrderUpdate::class,
            \AriyaInfoTech\MyOrder\Model\ResourceModel\OrderUpdate::class
        );
    }
}

