<?php
/**
 * Form container for refer edit/new
 */
namespace DreamSites\ReferaFriend\Block\Adminhtml\Refer;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;

class Edit extends Container
{
    /**
     * Core registry
     *
     * @var Registry
     */
    // protected $coreRegistry;

    // /**
    //  * Current refer record id
    //  *
    //  * @var bool|int
    //  */
    // protected $referId = false;

    // /**
    //  * Constructor
    //  *
    //  * @param \Magento\Backend\Block\Widget\Context $context
    //  * @param \Magento\Framework\Registry $registry
    //  * @param array $data
    //  */
    // public function __construct(
    //     \Magento\Backend\Block\Widget\Context $context,
    //     \Magento\Framework\Registry $registry,
    //     array $data = []
    // ) {
    //     $this->coreRegistry = $registry;
    //     parent::__construct($context, $data);
    // }

    // /**
    //  * Remove Delete button if record can't be deleted.
    //  *
    //  * @return void
    //  */
    // protected function _construct()
    // {
    //     $this->_objectId = 'refer_id';
    //     $this->_controller = 'adminhtml_refer';
    //     $this->_blockGroup = 'DreamSites_ReferaFriend';

    //     parent::_construct();

    //     $referId = $this->getreferId();
    //     if (!$referId) {
    //         $this->buttonList->remove('delete');
    //     }
    // }

    // /**
    //  * Retrieve the header text, either editing an existing record or creating a new one.
    //  *
    //  * @return \Magento\Framework\Phrase
    //  */
    // public function getHeaderText()
    // {
    //     $referId = $this->getreferId();
    //     if (!$referId) {
    //         return __('New Home Image Item');
    //     } else {
    //         return __('Edit Home Image Item');
    //     }
    // }

    // public function getreferId()
    // {
    //     if (!$this->referId) {
    //         $this->referId=$this->coreRegistry->registry('current_image_id');
    //     }
    //     return $this->referId;
    // }

}
