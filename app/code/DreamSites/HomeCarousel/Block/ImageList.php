<?php
namespace DreamSites\HomeCarousel\Block;

use Magento\Framework\View\Element\Template;
use DreamSites\HomeCarousel\Model\ResourceModel\Image\Collection as ImageCollection;

class ImageList extends Template
{
    /**
     * Image collection
     *
     * @var ImageCollection
     */
    protected $_imageCollection;

    /**
     * Image resource model
     *
     * @var \DreamSites\HomeCarousel\Model\ResourceModel\Image\CollectionFactory
     */
    protected $_imageColFactory;

    /**
     * @param Template\Context $context
     * @param \DreamSites\HomeCarousel\Model\ResourceModel\Image\CollectionFactory $collectionFactory
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Template\Context $context,
        \DreamSites\HomeCarousel\Model\ResourceModel\Image\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_imageColFactory = $collectionFactory;
        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * Get Image Items Collection
     * @return ImageCollection
     */
    public function getCarouselImages()
    {
        if (null === $this->_imageCollection) {
            $this->_imageCollection = $this->_imageColFactory->create();
            $this->_imageCollection->addFieldToFilter('is_active', 1);
        }
        return $this->_imageCollection;
    }
}
