<?php
/**
 * Class CustomerPhotos
 * Author: Kashif Bhatti
 * 13/11/2025
 */

namespace DreamSites\CustomerPhotos\Block;

use Magento\Framework\View\Element\Template;
use DreamSites\CustomerPhotos\Model\ResourceModel\Image\Collection as ImageCollection;

class CustomerPhotos extends Template
{
    /**
     * @var ImageCollection
     */
    protected $_imageCollection;

    /**
     * @var \DreamSites\CustomerPhotos\Model\ResourceModel\Image\CollectionFactory
     */
    protected $_imageColFactory;

    /**
     * @param Template\Context $context
     * @param \DreamSites\CustomerPhotos\Model\ResourceModel\Image\CollectionFactory $collectionFactory
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Template\Context $context,
        \DreamSites\CustomerPhotos\Model\ResourceModel\Image\CollectionFactory $collectionFactory,
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
    public function getCustomerPhotos()
    {
        if (null === $this->_imageCollection) {
            $this->_imageCollection = $this->_imageColFactory->create();
            $this->_imageCollection->addFieldToFilter('is_active', 1);
        }
        return $this->_imageCollection;
    }
}
