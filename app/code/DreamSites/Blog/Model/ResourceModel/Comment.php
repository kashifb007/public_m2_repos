<?php
namespace DreamSites\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Comment extends AbstractDb
{

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->_date = $date;
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('dreamsites_blog_comment', 'comment_id');
    }

    /**
     * Process page data before saving
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {

        if ($object->isObjectNew() && !$object->hasData('created_at')) {
            $object->setData('created_at', $this->_date->gmtDate());
        }

        $object->setData('updated_at', $this->_date->gmtDate());

        return parent::_beforeSave($object);
    }

    public function getPageId(\DreamSites\Blog\Model\Comment $comment)
    {
        return $comment->getPageId();
    }

    public function getAuthorName(\DreamSites\Blog\Model\Comment $comment)
    {
        return $comment->getAuthorName();
    }

    public function getAuthorEmail(\DreamSites\Blog\Model\Comment $comment)
    {
        return $comment->getAuthorEmail();
    }

    public function getContent(\DreamSites\Blog\Model\Comment $comment)
    {
        return $comment->getContent();
    }

    public function getCommentId(\DreamSites\Blog\Model\Comment $comment)
    {
        return $comment->getCommentId();
    }

    public function getIsApproved(\DreamSites\Blog\Model\Comment $comment)
    {
        return $comment->getIsApproved();
    }
}
