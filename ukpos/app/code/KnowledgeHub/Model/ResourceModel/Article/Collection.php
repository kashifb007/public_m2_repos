<?php
/**
 *
 * Collection.php
 *
 * 31/01/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Model\ResourceModel\Article;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Ukpos\KnowledgeHub\Model\Article',
            'Ukpos\KnowledgeHub\Model\ResourceModel\Article'
        );
    }

}