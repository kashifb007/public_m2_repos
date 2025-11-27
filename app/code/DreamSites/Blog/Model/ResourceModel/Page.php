<?php
/**
 * Page MySQL Resource
 */
namespace DreamSites\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Page extends AbstractDb
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
        $this->_init('dreamsites_blog', 'page_id');
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

    public function getTitle(\DreamSites\Blog\Model\Page $page)
    {
        return $page->getTitle();
    }

    public function getPageId(\DreamSites\Blog\Model\Page $page)
    {
        return $page->getPageId();
    }

    public function getContent(\DreamSites\Blog\Model\Page $page)
    {
        return $page->getContent();
    }

    public function getImageFilename(\DreamSites\Blog\Model\Page $page)
    {
        return $page->getImageFilename();
    }

    public function getImageAlt(\DreamSites\Blog\Model\Page $page)
    {
        return $page->getImageAlt();
    }

    public function getPermalink(\DreamSites\Blog\Model\Page $page)
    {
        return $page->getPermalink();
    }

    public function getIsActive(\DreamSites\Blog\Model\Page $page)
    {
        return $page->getIsActive();
    }

    public function getHasComments(\DreamSites\Blog\Model\Page $page)
    {
        return $page->getHasComments();
    }
}
