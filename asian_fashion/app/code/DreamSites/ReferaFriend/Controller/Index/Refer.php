<?php
namespace DreamSites\ReferaFriend\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Refer extends \Magento\Framework\App\Action\Action
{
//referafriend/index/refer

public function execute()
{


	// Redirect to your form page (or anywhere you want or any actions you wish to take place first... after the form is submitted)
	$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
	$resultRedirect->setUrl('/referafriend/index/test');

	return $resultRedirect;
}

}