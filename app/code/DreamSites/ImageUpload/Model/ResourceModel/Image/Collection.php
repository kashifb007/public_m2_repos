<?php
namespace DreamSites\ImageUpload\Model\ResourceModel\Image;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package DreamSites\ImageUpload\Model\ResourceModel\Image
 */
class Collection extends AbstractCollection
{
/**
* @var string
*/
protected $_idFieldName = 'image_id';
/**
* Define resource model
* @return void
*/
protected function _construct()
{
$this->_init('DreamSites\ImageUpload\Model\Image', 'DreamSites\ImageUpload\Model\ResourceModel\Image');
}
}
