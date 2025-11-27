<?php
/**
 * Product Name Column Renderer
 */
namespace DreamSites\CustomerPhotos\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Catalog\Api\ProductRepositoryInterface;

class ProductName extends Column
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param ProductRepositoryInterface $productRepository
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        ProductRepositoryInterface $productRepository,
        array $components = [],
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['product_id'])) {
                    try {
                        $product = $this->productRepository->getById($item['product_id']);
                        $item['product_id'] = html_entity_decode($product->getName(), ENT_QUOTES, 'UTF-8');
                    } catch (\Exception $e) {
                        $item['product_id'] = 'Product ID: ' . $item['product_id'] . ' (Not Found)';
                    }
                }
            }
        }

        return $dataSource;
    }
}
