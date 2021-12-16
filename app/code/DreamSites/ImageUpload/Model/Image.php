<?php
namespace DreamSites\ImageUpload\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Image
 * @package DreamSites\ImageUpload\Model
 */
class Image extends AbstractModel
{
/**
* Initialize resource model
* @return void
*/
	protected function _construct()
	{
		$this->_init('DreamSites\ImageUpload\Model\ResourceModel\Image');
	}
}
