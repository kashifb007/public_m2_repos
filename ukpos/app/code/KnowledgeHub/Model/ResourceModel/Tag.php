<?php
/**
 *
 * Tag.php
 *
 * 05/02/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Tag extends AbstractDb
{

    /**
     * Initialize resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ukpos_knowledgehub_tag', 'tag_id');
    }

    public function getTag(\Ukpos\KnowledgeHub\Model\Tag $tag)
    {
        return $tag->getTag();
    }

    public function getTagId(\Ukpos\KnowledgeHub\Model\Tag $tag)
    {
        return $tag->getTagId();
    }
}