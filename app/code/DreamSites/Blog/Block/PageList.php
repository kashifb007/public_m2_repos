<?php
/**
 * List contents of dreamsites_blog table
 *
 * @package DreamSites_Blog
 */
namespace DreamSites\Blog\Block;

use DreamSites\Blog\Model\ResourceModel\Page\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use DreamSites\Blog\Model\ResourceModel\Page\Collection as PageCollection;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;

class PageList extends Template
{
    /**
     * Page collection
     *
     * @var PageCollection
     */
    protected $_pageCollection;

    /**
     * Page resource model
     *
     * @var CollectionFactory
     */
    protected $_pageColFactory;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->_pageColFactory = $collectionFactory;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * Get Header from configuration value
     * @return string
     */
    public function getHeader()
    {
        return $this->_scopeConfig->getValue('blog/page/header', ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get Blog Page Items Collection
     * @return PageCollection
     */
    public function getPageItems()
    {
        if (null === $this->_pageCollection) {
            $this->_pageCollection = $this->_pageColFactory->create();
            $this->_pageCollection->addFieldToFilter('is_active', 1);
            $this->_pageCollection->setOrder('page_id', 'DESC');
        }
        return $this->_pageCollection;
    }

    public function getBlogIntro()
    {
        return $this->_scopeConfig->getValue('dreamsites_blog/page/header', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
