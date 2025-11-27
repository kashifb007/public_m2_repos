<?php
/**
 * Form container for Page edit/new
 */
namespace DreamSites\Blog\Block\Adminhtml\Page;

use Magento\Backend\Block\Widget\Form\Container;

class Edit extends Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * Current page record id
     *
     * @var bool|int
     */
    protected $pageId=false;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Remove Delete button if record can't be deleted.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'page_id';
        $this->_controller = 'adminhtml_page';
        $this->_blockGroup = 'DreamSites_Blog';

        parent::_construct();

        $pageId = $this->getPageId();
        if (!$pageId) {
            $this->buttonList->remove('delete');
        }
    }

    /**
     * Retrieve the header text, either editing an existing record or creating a new one.
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        $pageId = $this->getPageId();
        if (!$pageId) {
            return __('New Blog Item');
        } else {
            return __('Edit Blog Item');
        }
    }

    public function getPageId()
    {
        if (!$this->pageId) {
            $this->pageId=$this->coreRegistry->registry('current_page_id');
        }
        return $this->pageId;
    }

}
