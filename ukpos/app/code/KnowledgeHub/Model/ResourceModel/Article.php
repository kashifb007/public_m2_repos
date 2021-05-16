<?php
/**
 *
 * Article.php
 *
 * 18/02/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Article
{

    /**
     * Initialize resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init('cms_page', 'page_id');
    }

}