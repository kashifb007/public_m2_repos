<?php
/**
 * Image Model
 */
namespace DreamSites\CustomerPhotos\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Image extends AbstractModel
{
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param StoreManagerInterface $storeManager
     * @param ProductRepositoryInterface $productRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        StoreManagerInterface $storeManager,
        ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        $this->_storeManager = $storeManager;
        $this->productRepository = $productRepository;
        parent::__construct($context, $registry, null, null, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('DreamSites\CustomerPhotos\Model\ResourceModel\Image');
        parent::_construct();
    }

    /**
     * @return mixed
     */
    public function getImageId()
    {
        return $this->getData('image_id');
    }

    /**
     * @return mixed
     */
    public function getCustomerName()
    {
        return $this->getData('customer_name');
    }

    /**
     * @param $customerName
     * @return Image
     */
    public function setCustomerName($customerName)
    {
        return $this->setData('customer_name', $customerName);
    }

    /**
     * @return mixed
     */
    public function getImageFilename()
    {
        return $this->getData('image_filename');
    }

    /**
     * @return mixed
     * get product details from product id
     */
    public function getProductDetails()
    {
        $productId = $this->getProductId();
        if (!$productId) {
            return null;
        }

        try {
            $product = $this->productRepository->getById($productId);
            return [$product->getName(), $product->getProductUrl()];
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * @param $imageFilename
     * @return Image
     */
    public function setImageFilename($imageFilename)
    {
        return $this->setData('image_filename', $imageFilename);
    }

    public function getMediaPath()
    {
        return $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . 'photos/' . $this->getImageFilename();
    }

    /**
     * @return mixed
     */
    public function getInstagram()
    {
        return $this->getData('instagram');
    }

    /**
     * @param $instagram
     * @return Image
     */
    public function setInstagram($instagram)
    {
        return $this->setData('instagram', $instagram);
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->getData('product_id');
    }

    /**
     * @param $productId
     * @return Image
     */
    public function setProductId($productId)
    {
        return $this->setData('product_id', $productId);
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->getData('is_active');
    }

    /**
     * @param $isActive
     * @return Image
     */
    public function setIsActive($isActive)
    {
        return $this->setData('is_active', $isActive);
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->getData('created_at');
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->getData('updated_at');
    }
}
