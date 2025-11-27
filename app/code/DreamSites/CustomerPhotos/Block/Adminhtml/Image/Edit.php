<?php
/**
 * Admin Edit Image Block
 */
namespace DreamSites\CustomerPhotos\Block\Adminhtml\Image;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

class Edit extends Container
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'image_id';
        $this->_blockGroup = 'DreamSites_CustomerPhotos';
        $this->_controller = 'adminhtml_image';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Photo'));
        $this->buttonList->update('delete', 'label', __('Delete Photo'));
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('current_image_id')) {
            return __("Edit Customer Photo");
        } else {
            return __('New Customer Photo');
        }
    }
}
