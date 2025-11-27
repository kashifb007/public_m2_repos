<?php
/**
 * Form container for Image edit/new
 */
namespace DreamSites\HomeCarousel\Block\Adminhtml\Image;

use Magento\Backend\Block\Widget\Form\Container;

class Edit extends Container
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @var bool|int
     */
    protected $imageId = false;

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
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'image_id';
        $this->_controller = 'adminhtml_image';
        $this->_blockGroup = 'DreamSites_HomeCarousel';

        parent::_construct();

        $imageId = $this->getImageId();
        if (!$imageId) {
            $this->buttonList->remove('delete');
        }
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        $imageId = $this->getImageId();
        if (!$imageId) {
            return __('New Home Carousel Item');
        } else {
            return __('Edit Home Carousel Item');
        }
    }

    public function getImageId()
    {
        if (!$this->imageId) {
            $this->imageId=$this->coreRegistry->registry('current_image_id');
        }
        return $this->imageId;
    }
}
