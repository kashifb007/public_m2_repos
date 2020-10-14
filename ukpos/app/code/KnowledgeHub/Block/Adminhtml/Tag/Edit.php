<?php
/**
 *
 * Edit.php
 *
 * 07/02/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Block\Adminhtml\Tag;

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
     * Current tag record id
     *
     * @var bool|int
     */
    protected $tagId=false;

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
        $this->_objectId = 'tag_id';
        $this->_controller = 'adminhtml_tag';
        $this->_blockGroup = 'Ukpos_KnowledgeHub';

        parent::_construct();

        $tagId = $this->getTagId();
        if (!$tagId) {
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
        $tagId = $this->getTagId();
        if (!$tagId) {
            return __('New Tag Item');
        } else {
            return __('Edit Tag Item');
        }
    }

    public function getTagId()
    {
        if (!$this->tagId) {
            $this->tagId=$this->coreRegistry->registry('current_tag_id');
        }
        return $this->tagId;
    }
    
}