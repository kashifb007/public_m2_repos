<?php
/**
 * Controller to render single blog page
 * URL: /blog/{page_id}/{permalink}
 *
 * @package DreamSites_Blog
 */
namespace DreamSites\Blog\Controller\View;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\ForwardFactory;
use DreamSites\Blog\Model\PageFactory as BlogPageFactory;
use Magento\Store\Model\StoreManagerInterface;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var ForwardFactory
     */
    protected $forwardFactory;

    /**
     * @var BlogPageFactory
     */
    protected $blogPageFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ForwardFactory $forwardFactory
     * @param BlogPageFactory $blogPageFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ForwardFactory $forwardFactory,
        BlogPageFactory $blogPageFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->forwardFactory = $forwardFactory;
        $this->blogPageFactory = $blogPageFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Render single blog page
     *
     * @return \Magento\Framework\View\Result\Page|\Magento\Framework\Controller\Result\Forward
     */
    public function execute()
    {
        $pageId = $this->getRequest()->getParam('id');

        if (!$pageId) {
            return $this->forwardNoRoute();
        }

        // Load the blog page
        $blogPage = $this->blogPageFactory->create()->load($pageId);

        // Check if page exists and is active
        if (!$blogPage->getPageId() || !$blogPage->getIsActive()) {
            return $this->forwardNoRoute();
        }

        // Create and return the page
        $resultPage = $this->resultPageFactory->create();

        // Set page title
        $resultPage->getConfig()->getTitle()->set($blogPage->getTitle());

        // Add breadcrumbs
        $this->addBreadcrumbs($resultPage, $blogPage);

        // Set canonical URL with permalink for SEO
        $canonicalUrl = $this->getCanonicalUrl($blogPage);
        $resultPage->getConfig()->addRemotePageAsset(
            $canonicalUrl,
            'canonical',
            ['attributes' => ['rel' => 'canonical']]
        );

        return $resultPage;
    }

    /**
     * Add breadcrumbs to the page
     *
     * @param \Magento\Framework\View\Result\Page $resultPage
     * @param \DreamSites\Blog\Model\Page $blogPage
     * @return void
     */
    protected function addBreadcrumbs($resultPage, $blogPage)
    {
        $breadcrumbs = $resultPage->getLayout()->getBlock('breadcrumbs');

        if ($breadcrumbs) {
            // Add Home breadcrumb
            $breadcrumbs->addCrumb(
                'home',
                [
                    'label' => __('Home'),
                    'title' => __('Go to Home Page'),
                    'link' => $this->storeManager->getStore()->getBaseUrl()
                ]
            );

            // Add Blog listing breadcrumb
            $breadcrumbs->addCrumb(
                'blog',
                [
                    'label' => __('Blog'),
                    'title' => __('Go to Blog'),
                    'link' => $this->_url->getUrl('blog')
                ]
            );

            // Add current blog page breadcrumb
            $breadcrumbs->addCrumb(
                'blog_page',
                [
                    'label' => $blogPage->getTitle(),
                    'title' => $blogPage->getTitle()
                ]
            );
        }
    }

    /**
     * Get canonical URL for the blog page
     *
     * @param \DreamSites\Blog\Model\Page $blogPage
     * @return string
     */
    protected function getCanonicalUrl($blogPage)
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
        $pageId = $blogPage->getPageId();
        $permalink = $blogPage->getPermalink();

        // Build URL: /blog/{page_id}/{permalink}
        $url = rtrim($baseUrl, '/') . '/blog/' . $pageId;

        if ($permalink) {
            // Ensure permalink is URL-safe
            $permalink = trim($permalink, '/');
            $url .= '/' . $permalink;
        }

        return $url;
    }

    /**
     * Forward to 404 page
     *
     * @return \Magento\Framework\Controller\Result\Forward
     */
    protected function forwardNoRoute()
    {
        $resultForward = $this->forwardFactory->create();
        $resultForward->setController('index');
        $resultForward->forward('noroute');
        return $resultForward;
    }
}
