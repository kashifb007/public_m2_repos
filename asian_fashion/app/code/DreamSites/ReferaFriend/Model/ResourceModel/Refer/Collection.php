<?php

namespace DreamSites\ReferaFriend\Model\ResourceModel\Refer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'refer_id';

    /**
     * Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('DreamSites\ReferaFriend\Model\Refer', 'DreamSites\ReferaFriend\Model\ResourceModel\Refer');
    }
}
