<?php
/**
 * Block for blog comments
 *
 * @package DreamSites_Blog
 */
namespace DreamSites\Blog\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use DreamSites\Blog\Model\ResourceModel\Comment\CollectionFactory as CommentCollectionFactory;
use DreamSites\Blog\Model\PageFactory;

class CommentList extends Template
{
    /**
     * @var CommentCollectionFactory
     */
    protected $commentCollectionFactory;

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var \DreamSites\Blog\Model\Page
     */
    protected $blogPage;

    /**
     * @param Context $context
     * @param CommentCollectionFactory $commentCollectionFactory
     * @param PageFactory $pageFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        CommentCollectionFactory $commentCollectionFactory,
        PageFactory $pageFactory,
        array $data = []
    ) {
        $this->commentCollectionFactory = $commentCollectionFactory;
        $this->pageFactory = $pageFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get current blog page
     *
     * @return \DreamSites\Blog\Model\Page
     */
    public function getBlogPage()
    {
        if (!$this->blogPage) {
            $pageId = $this->getRequest()->getParam('id');
            $this->blogPage = $this->pageFactory->create()->load($pageId);
        }
        return $this->blogPage;
    }

    /**
     * Check if comments are enabled for this page
     *
     * @return bool
     */
    public function hasCommentsEnabled()
    {
        return (bool)$this->getBlogPage()->getHasComments();
    }

    /**
     * Get approved comments for current page
     *
     * @return \DreamSites\Blog\Model\ResourceModel\Comment\Collection
     */
    public function getComments()
    {
        $pageId = $this->getRequest()->getParam('id');

        $collection = $this->commentCollectionFactory->create()
            ->addFieldToFilter('page_id', $pageId)
            ->addFieldToFilter('is_approved', 1)
            ->setOrder('comment_id', 'DESC');

        return $collection;
    }

    /**
     * Get form action URL
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('blog/comment/post');
    }

    /**
     * Get current page ID
     *
     * @return int
     */
    public function getPageId()
    {
        return $this->getRequest()->getParam('id');
    }
}
