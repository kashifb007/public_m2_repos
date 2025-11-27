<?php
/**
 * Image Collection
 */
namespace DreamSites\CustomerPhotos\Model\ResourceModel\Image;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'image_id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('DreamSites\CustomerPhotos\Model\Image', 'DreamSites\CustomerPhotos\Model\ResourceModel\Image');
    }
}
