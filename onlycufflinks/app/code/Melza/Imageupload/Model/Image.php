<?php
namespace Melza\Imageupload\Model;
use Magento\Framework\Model\AbstractModel;
class Image extends AbstractModel
{
/**
* Initialize resource model
* @return void
*/
	protected function _construct()
	{
		$this->_init('Melza\Imageupload\Model\ResourceModel\Image');
	}
}