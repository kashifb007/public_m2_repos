<?php

/**
 ** 08/06/2021
 ** @author Kashif
 **/

namespace Dreamsites\AliDropShipping\Observer;

use Magento\Backend\Model\Session as ImageSession;
use Magento\Catalog\Model\Product\Gallery\Processor;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\ResourceModel\Product\Gallery;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class ProductSaveAfter
 * @package Dreamsites\AliDropShipping\Observer
 **/
class ProductSaveAfter implements ObserverInterface
{
    /**
     * @var Gallery
     */
    protected $productGallery;

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
        ImageSession $imageSession,
        Gallery $productGallery
    )
    {
        $this->productRepository = $productRepository;
        $this->imageSession = $imageSession;
        $this->productGallery = $productGallery;
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
     */
    public function execute(Observer $observer): void
    {
        if ($this->getImageSession()->getImages() !== null) {

            $product = $observer->getProduct();
            $tmpImages = $this->getImageSession()->getImages();
            $this->getImageSession()->setImages(null);

            //if checked then remove all previous images before uploading
            if (null !== $this->getImageSession()->getClear()) {
                $this->getImageSession()->setClear(null);
                $gallery = $product->getMediaGalleryImages();
                if (count($gallery) > 0) {
                    foreach ($gallery as $image) {
                        $this->productGallery->deleteGallery($image->getValueId());
                    }
                    $product->setMediaGalleryEntries([]);
                }
            }

            $firstpass = true;
            foreach ($tmpImages as $img) {
                if ($firstpass) {
                    $firstpass = false;
                    $product->setImage(
                        $img
                    )->setSmallImage(
                        $img
                    )->setThumbnail(
                        $img
                    )->addImageToMediaGallery($img, array('image', 'small_image', 'thumbnail'), false, false);
                } else {
                    $product->addImageToMediaGallery($img, null, false, false);
                }
            }

            $product->save();
        }
    }

}
