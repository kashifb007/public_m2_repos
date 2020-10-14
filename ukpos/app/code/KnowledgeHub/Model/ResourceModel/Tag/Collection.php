<?php
/**
 *
 * Collection.php
 *
 * 05/02/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Model\ResourceModel\Tag;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected $_idFieldName = 'tag_id';

    protected function _construct()
    {
        $this->_init(
            'Ukpos\KnowledgeHub\Model\Tag',
            'Ukpos\KnowledgeHub\Model\ResourceModel\Tag'
        );
    }

}