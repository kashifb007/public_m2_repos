<?php
/**
 * Page List Collection used in configuration option blog/page/selectblog
 */
namespace DreamSites\Blog\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use DreamSites\Blog\Model\ResourceModel\Page\CollectionFactory;

class PageList implements ArrayInterface
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
