<?php
/**
 * Page Model
 */
namespace DreamSites\Blog\Model;

use Magento\Framework\Model\AbstractModel;

class Page extends AbstractModel
{
    private $_storeManager;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('DreamSites\Blog\Model\ResourceModel\Page');
        parent::_construct();
    }

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_storeManager = $storeManager;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
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
    public function getTitle()
    {
        return $this->getData('title');
    }

    /**
     * @param $title
     * @return Page
     */
    public function setTitle($title)
    {
        return $this->setData('title', $title);
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->getData('is_active');
    }

    /**
     * @param $isActive
     * @return Page
     */
    public function setIsActive($isActive)
    {
        return $this->setData('is_active', $isActive);
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
    public function getHasComments()
    {
        return $this->getData('has_comments');
    }

    /**
     * @param $hasComments
     * @return Page
     */
    public function setHasComments($hasComments)
    {
        return $this->setData('has_comments', $hasComments);
    }

    /**
     * @return mixed
     */
    public function getImageFilename()
    {
        return $this->getData('image_filename');
    }

    /**
     * @param $imageFilename
     * @return Page
     */
    public function setImageFilename($imageFilename)
    {
        return $this->setData('image_filename', $imageFilename);
    }

    /**
     * @return mixed
     */
    public function getImageAlt()
    {
        return $this->getData('image_alt');
    }

    /**
     * @param $imageAlt
     * @return Page
     */
    public function setImageAlt($imageAlt)
    {
        return $this->setData('image_alt', $imageAlt);
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
     * @return Page
     */
    public function setContent($content)
    {
        return $this->setData('content', $content);
    }

    /**
     * @return mixed
     */
    public function getPermalink()
    {
        return $this->getData('permalink');
    }

    /**
     * @param $permalink
     * @return Page
     */
    public function setPermalink($permalink)
    {
        return $this->setData('permalink', $permalink);
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        $permalink = $this->getData('permalink');
        $pageId = $this->getData('page_id');
        if ($permalink) {
            return sprintf("/blog/%d/%s", $pageId, $permalink);
        }
        return sprintf("/blog/%d/", $pageId);
    }

    public function getMediaUrl()
    {
        $fileName = $this->getImageFilename();
        if (!$fileName) {
            return '';
        }
        return rtrim($this->_storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ), '/') . '/blog/' . $fileName;
    }
}
