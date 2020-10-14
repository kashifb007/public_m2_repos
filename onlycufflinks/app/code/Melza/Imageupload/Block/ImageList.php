<?php
namespace Melza\Imageupload\Block;

use Magento\Framework\View\Element\Template;
use Melza\Imageupload\Model\ResourceModel\Image\Collection as ImageCollection;
use Magento\Store\Model\ScopeInterface;

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
     * @var \Melza\Imageupload\Model\ResourceModel\Image\CollectionFactory
     */
    protected $_imageColFactory;

    /**
     * @param Template\Context $context
     * @param \Melza\Imageupload\Model\ResourceModel\Image\CollectionFactory $collectionFactory
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Template\Context $context,
        \Melza\Imageupload\Model\ResourceModel\Image\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_imageColFactory = $collectionFactory;
        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * Get Header from configuration value
     * @return string
     */
    // public function getHeader()
    // {
    //     return $this->_scopeConfig->getValue('imageupload/image/header', ScopeInterface::SCOPE_STORE);
    // }

    /**
     * Get Image Items Collection
     * @return ImageCollection
     */
    public function getHomeImages()
    {
        if (null === $this->_imageCollection) {
            $this->_imageCollection = $this->_imageColFactory->create();
        }
        return $this->_imageCollection;
    }
} 