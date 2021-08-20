<?php

/**
 ** 02/06/2021
 ** @author Kashif
 **/


namespace Dreamsites\AliDropShipping\Controller\Adminhtml\System\Config;

use Dreamsites\AliDropShipping\Model\Scraper;
use Magento\Backend\App\Action;
use Magento\Backend\Block\System\Store\Store;
use Magento\Backend\Model\Session as ImageSession;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Backend\Model\Session as UrlSession;
use Magento\Store\Model\StoreManagerInterface as StoreManager;

/**
 * Class ImportImages
 * @package Dreamsites\AliDropShipping\Controller
 **/
class Import extends Action
{

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var Scraper
     */
    protected $scraper;

    /**
     * @var UrlSession
     */
    private $urlSession;

    /**
     * @var StoreManager
     */
    private $storeManager;

    /**
     * @var ImageSession
     */
    public $imageSession;

    /**
     * ImportImages constructor.
     * @param Action\Context $context
     * @param JsonFactory $resultJsonFactory
     * @param Scraper $scraper
     * @param UrlSession $urlSession
     * @param StoreManager $storeManager
     * @param UrlSession $imageSession
     */
    public function __construct(
        Action\Context $context,
        JsonFactory $resultJsonFactory,
        Scraper $scraper,
        UrlSession $urlSession,
        StoreManager $storeManager,
        ImageSession $imageSession
    )
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->scraper = $scraper;
        $this->urlSession = $urlSession;
        $this->storeManager = $storeManager;
        $this->imageSession = $imageSession;
        parent::__construct($context);
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
    private function getImageSession(): ImageSession
    {
        return $this->imageSession;
    }

    /**
     * @return Json
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $url = $_POST['url'];
        $checked = $_POST['checked'] === "true" ? 1 : 0;
        if ($checked === 1) {
            $this->getImageSession()->setClear(true);
        } else {
            $this->getImageSession()->setClear(null);
        }

        $storeUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        $imagesArray = [];

        //If url is valid, set the import session to true for the observer to pick up.
        if (filter_var($url, FILTER_VALIDATE_URL) && stripos($url, 'aliexpress.com') !== false) {
            $images = $this->scraper->getImages($url);
            if (array_key_exists('error', $images)) {
                if ($images[0]['error'] === 500) {
                    $errorMessage = 'Error retrieving images.';
                }
            } else {
                $errorMessage = '';
                foreach ($images as $image) {
                    $start = strrpos($image, '/');
                    $imagesArray[] = $storeUrl . 'catalog/product/cache' . substr($image, $start);
                }
                $this->getUrlSession()->setIsUrl(true);
            }
        } else {
            $errorMessage = 'Not a valid AliExpress Url.';
            $this->getUrlSession()->setUrl(null);
        }

        /** @var Json $result */
        $result = $this->resultJsonFactory->create();

        if (count($imagesArray)) {
            $message = implode('|', $imagesArray);
        }

        return $result->setData(['message' => $message, 'errorMessage' => $errorMessage]);
    }

}
