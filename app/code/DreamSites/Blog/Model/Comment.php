<?php
namespace DreamSites\Blog\Model;

use Magento\Framework\Model\AbstractModel;

class Comment extends AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('DreamSites\Blog\Model\ResourceModel\Comment');
        parent::_construct();
    }

    /**
     * @return mixed
     */
    public function getCommentId()
    {
        return $this->getData('comment_id');
    }

    /**
     * @return mixed
     */
    public function getPageId()
    {
        return $this->getData('page_id');
    }

    /**
     * @return mixed
     */
    public function getAuthorName()
    {
        return $this->getData('author_name');
    }

    /**
     * @param $authorName
     * @return Comment
     */
    public function setAuthorName($authorName)
    {
        return $this->setData('author_name', $authorName);
    }

    /**
     * @return mixed
     */
    public function getAuthorEmail()
    {
        return $this->getData('author_email');
    }

    /**
     * @param $authorEmail
     * @return Comment
     */
    public function setAuthorEmail($authorEmail)
    {
        return $this->setData('author_email', $authorEmail);
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->getData('created_at');
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->getData('updated_at');
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->getData('content');
    }

    /**
     * @param $content
     * @return Comment
     */
    public function setContent($content)
    {
        return $this->setData('content', $content);
    }

    /**
     * @return mixed
     */
    public function getIsApproved()
    {
        return $this->getData('is_approved');
    }

    /**
     * @param $isApproved
     * @return Comment
     */
    public function setIsApproved($isApproved)
    {
        return $this->setData('is_approved', $isApproved);
    }
}
