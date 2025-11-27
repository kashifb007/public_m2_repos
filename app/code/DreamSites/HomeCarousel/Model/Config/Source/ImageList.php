<?php
/**
 * Page List Collection used in configuration option blog/page/selectblog
 */
namespace DreamSites\HomeCarousel\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use DreamSites\HomeCarousel\Model\ResourceModel\Image\CollectionFactory;

class ImageList implements ArrayInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * To option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $this->options = $this->collectionFactory->create()->toOptionIdArray();
        }
        return $this->options;
    }
}
