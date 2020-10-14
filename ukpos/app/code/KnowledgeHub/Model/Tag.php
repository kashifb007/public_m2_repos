<?php
/**
 *
 * Tag.php
 *
 * 04/02/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Model;

use Magento\Framework\Model\AbstractModel;

class Tag extends AbstractModel
{

    protected $tag;

    protected function _construct()
    {
        $this->_init('Ukpos\KnowledgeHub\Model\ResourceModel\Tag');
        parent::_construct();
    }

    /**
     * @return mixed
     */
    public function getTagId()
    {
        return $this->getData('tag_id');
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->getData('tag');
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->getData('enabled');
    }

    /**
     * @param $tag
     * @return Tag
     */
    public function setTag($tag)
    {
        return $this->setData('tag', $tag);
    }

}