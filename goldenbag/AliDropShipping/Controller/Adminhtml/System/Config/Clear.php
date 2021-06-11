<?php

/**
 ** 05/06/2021
 ** @author Kashif
 **/


namespace Dreamsites\AliDropShipping\Controller\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\Model\Session as ImageSession;
use Magento\Backend\Model\Session as UrlSession;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use MagicToolbox\MagicScroll\Model\Image;

/**
 * Class Clear
 * @package Dreamsites\AliDropShipping\Controller\Adminhtml\System\Config
 **/
class Clear extends Action
{

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var ImageSession
     */
    public $imageSession;

    /**
     * @var UrlSession
     */
    private $urlSession;

    public function __construct(
        Action\Context $context,
        JsonFactory $resultJsonFactory,
        ImageSession $imageSession
    )
    {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->imageSession = $imageSession;
    }

    /**
     * @return UrlSession
     */
    private function getUrlSession()
    {
        return $this->urlSession;
    }

    /**
     * @return ImageSession
     */
    private function getImageSession()
    {
        return $this->imageSession;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->getUrlSession()->unsetIsUrl();
        $this->getImageSession()->unsetImages();

        /** @var Json $result */
        $result = $this->resultJsonFactory->create();

        return $result->setData(['message' => '']);

    }

}
