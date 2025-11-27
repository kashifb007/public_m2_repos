<?php
/**
 * Comment Collection
 *
 * @package DreamSites_Blog
 */
namespace DreamSites\Blog\Model\ResourceModel\Comment;

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
            'DreamSites\Blog\Model\Comment',
            'DreamSites\Blog\Model\ResourceModel\Comment'
        );
    }
}
