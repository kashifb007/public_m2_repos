<?php

/**
 ** 08/06/2021
 ** @author Kashif
 **/

namespace Dreamsites\AliDropShipping\Observer;

use Magento\Backend\Model\Session as ImageSession;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class ProductSaveAfter
 * @package Dreamsites\AliDropShipping\Observer
 **/
class ProductSaveAfter implements ObserverInterface
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var ImageSession
     */
    public $imageSession;

    /**
     * @param ProductRepository $productRepository
     * @param ImageSession $imageSession
     */
    public function __construct(
        ProductRepository $productRepository,
        ImageSession $imageSession
    )
    {
        $this->productRepository = $productRepository;
        $this->imageSession = $imageSession;
    }

    /**
     * @return ImageSession
     */
    private function getImageSession(): ImageSession
    {
        return $this->imageSession;
    }

    /**
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function execute(Observer $observer): void
    {
        if (null !== $this->getImageSession()->getImages()) {
            $product = $observer->getProduct();
            $tmpImages = $this->getImageSession()->getImages();

            //TODO set base, small, thumbnail separately

            foreach ($tmpImages as $img) {
                $product->addImageToMediaGallery($img, array('image', 'small_image', 'thumbnail'), false, false);
            }

            $this->getImageSession()->setImages(null);
            //$savedProduct = $this->productRepository->save($product);
            $product->save();
        }
    }

}
