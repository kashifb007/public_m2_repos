<?php
namespace Melza\Imageupload\Model\ResourceModel\Image;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
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
$this->_init('Melza\Imageupload\Model\Image', 'Melza\Imageupload\Model\ResourceModel\Image');
}
}