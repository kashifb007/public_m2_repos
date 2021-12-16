<?php
namespace DreamSites\HomeProducts\Block;
/**
 ** 11/09/2021
 ** @author Kashif
 **/

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Helper\Output as OutputHelper;
use Magento\Catalog\Model\Layer;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Url\Helper\Data;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template\Context;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Block\Product\ListProduct;

/**
 * Class ProductsList
 * @package DreamSites\ProductsList\Block
 */
class ProductsList extends ListProduct
{
    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var ProductRepository
     */
    protected $_productRepository;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * Catalog layer
     *
     * @var Layer
     */
    protected $_catalogLayer;

    /**
     * @var PostHelper
     */
    protected $_postDataHelper;

    /**
     * @var Data
     */
    protected $_urlHelper;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $_categoryRepository;

    /**
     * ProductsList constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param ProductRepository $productRepository
     * @param LoggerInterface $logger
     * @param PostHelper $postDataHelper
     * @param Resolver $layerResolver
     * @param CategoryRepositoryInterface $categoryRepository
     * @param Data $urlHelper
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Block\Product\Context $context,
        ProductRepository $productRepository,
        LoggerInterface $logger,
        PostHelper $postDataHelper,
        Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        Data $urlHelper
    )
    {
        $this->_scopeConfig = $scopeConfig;
        $this->_productRepository = $productRepository;
        $this->_logger = $logger;
        $this->_catalogLayer = $layerResolver->get();
        $this->_postDataHelper = $postDataHelper;
        $this->_categoryRepository = $categoryRepository;
        $this->_urlHelper = $urlHelper;
        parent::__construct(
            $context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper
        );
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        $homeProductsEnabled = filter_var($this->_scopeConfig->getValue('productadmin/general/product_enabled'), FILTER_VALIDATE_BOOLEAN);

        if ($homeProductsEnabled) {
            $productIds = explode(",", $this->_scopeConfig->getValue('productadmin/general/homeproductscsv'));
            $products = [];
            $count = 0;
            foreach ($productIds as $productId) {
                try {
                    /* @var $product \Magento\Catalog\Model\Product */
                    $product = $this->_productRepository->getById($productId);
                } catch (\Exception $e) {
                    $this->_logger->critical($e->getMessage());
                }
                $products[$count]['product'] = $product;
                $productImages = $product->getMediaGalleryImages();
                $productImage = $productImages->getFirstItem();
                $products[$count]['image'] = $productImage['url'];
                $count++;
            }

            return $products;
        }
        return [];
    }

}
