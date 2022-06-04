<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ariya\MyOrder\Model\ResourceModel\OrderUpdate;

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
            \Ariya\MyOrder\Model\OrderUpdate::class,
            \Ariya\MyOrder\Model\ResourceModel\OrderUpdate::class
        );
    }
}

