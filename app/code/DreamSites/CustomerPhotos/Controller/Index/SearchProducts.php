<?php
/**
 * Search Products AJAX Controller
 */
namespace DreamSites\CustomerPhotos\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Escaper;

class SearchProducts extends Action
{
    const MAX_RESULTS = 30;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param CollectionFactory $productCollectionFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        CollectionFactory $productCollectionFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Search for products
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $searchTerm = $this->getRequest()->getParam('q', '');

        if (strlen($searchTerm) < 3) {
            return $result->setData([
                'success' => true,
                'products' => []
            ]);
        }

        try {
            $collection = $this->productCollectionFactory->create();
            $collection->addAttributeToSelect(['name', 'small_image', 'thumbnail'])
                ->addAttributeToFilter('status', Status::STATUS_ENABLED)
                ->addAttributeToFilter(
                    'name',
                    ['like' => '%' . $searchTerm . '%']
                )
                ->addAttributeToFilter('visibility', [
                    'in' => [
                        Visibility::VISIBILITY_IN_CATALOG,
                        Visibility::VISIBILITY_IN_SEARCH,
                        Visibility::VISIBILITY_BOTH
                    ]
                ])
                ->setPageSize(self::MAX_RESULTS)
                ->setCurPage(1);

            $products = [];
            $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

            foreach ($collection as $product) {
                $imageUrl = '';
                if ($product->getThumbnail() && $product->getThumbnail() != 'no_selection') {
                    $imageUrl = $mediaUrl . 'catalog/product' . $product->getThumbnail();
                } elseif ($product->getSmallImage() && $product->getSmallImage() != 'no_selection') {
                    $imageUrl = $mediaUrl . 'catalog/product' . $product->getSmallImage();
                }

                $products[] = [
                    'id' => $product->getId(),
                    'name' => html_entity_decode($product->getName(), ENT_QUOTES, 'UTF-8'),
                    'image' => $imageUrl
                ];
            }

            return $result->setData([
                'success' => true,
                'products' => $products
            ]);

        } catch (\Exception $e) {
            return $result->setData([
                'success' => false,
                'message' => __('An error occurred while searching for products.')
            ]);
        }
    }
}
