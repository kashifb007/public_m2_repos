<?php
/**
 * Block for single blog page
 *
 * @package DreamSites_Blog
 * Author: Kashif Bhatti
 * 02/11/2025
 */

namespace DreamSites\Blog\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use DreamSites\Blog\Model\PageFactory;

class Single extends Template
{
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
     * @param PageFactory $pageFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        array $data = []
    ) {
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
     * Get page title
     *
     * @return string
     */
    public function getPageTitle()
    {
        return $this->getBlogPage()->getTitle();
    }

    /**
     * Get page content
     *
     * @return string
     */
    public function getPageContent()
    {
        return $this->getBlogPage()->getContent();
    }

    /**
     * Get page image filename
     *
     * @return string
     */
    public function getImageFilename()
    {
        return $this->getBlogPage()->getImageFilename();
    }

    /**
     * Get page image alt text
     *
     * @return string
     */
    public function getImageAlt()
    {
        return $this->getBlogPage()->getImageAlt();
    }

    /**
     * Get created date
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getBlogPage()->getCreatedAt();
    }
}
