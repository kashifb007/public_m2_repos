<?php
namespace DreamSites\ReferaFriend\Model;
use Magento\Framework\Model\AbstractModel;
class Refer extends AbstractModel
{
/**
* Initialize resource model
* @return void
*/
	protected function _construct()
	{
		$this->_init('DreamSites\ReferaFriend\Model\ResourceModel\Refer');
	}
}