<?php
/**
 * NewProducts Helper
 */

namespace DreamSites\NewProducts\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Swatches\Helper\Data as SwatchHelper;
use Magento\Swatches\Helper\Media as SwatchMediaHelper;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Review\Model\ResourceModel\Review\CollectionFactory as ReviewCollectionFactory;
use Magento\Review\Model\ReviewFactory;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper
{
    /**
     * @var SwatchHelper
     */
    protected $swatchHelper;

    /**
     * @var SwatchMediaHelper
     */
    protected $swatchMediaHelper;

    /**
     * @var ImageHelper
     */
    protected $imageHelper;

    /**
     * @var ReviewCollectionFactory
     */
    protected $reviewCollectionFactory;

    /**
     * @var ReviewFactory
     */
    protected $reviewFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param Context $context
     * @param SwatchHelper $swatchHelper
     * @param SwatchMediaHelper $swatchMediaHelper
     * @param ImageHelper $imageHelper
     * @param ReviewCollectionFactory $reviewCollectionFactory
     * @param ReviewFactory $reviewFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        SwatchHelper $swatchHelper,
        SwatchMediaHelper $swatchMediaHelper,
        ImageHelper $imageHelper,
        ReviewCollectionFactory $reviewCollectionFactory,
        ReviewFactory $reviewFactory,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->swatchHelper = $swatchHelper;
        $this->swatchMediaHelper = $swatchMediaHelper;
        $this->imageHelper = $imageHelper;
        $this->reviewCollectionFactory = $reviewCollectionFactory;
        $this->reviewFactory = $reviewFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * Get product review data
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return array
     */
    public function getProductReviewData($product)
    {
        $this->reviewFactory->create()->getEntitySummary($product, $this->storeManager->getStore()->getId());

        $ratingSummary = $product->getRatingSummary();

        // Get review count directly from collection
        $reviewCollection = $this->reviewCollectionFactory->create()
            ->addStatusFilter(\Magento\Review\Model\Review::STATUS_APPROVED)
            ->addEntityFilter('product', $product->getId())
            ->addStoreFilter($this->storeManager->getStore()->getId());

        $reviewsCount = $reviewCollection->getSize();

        return [
            'rating_summary' => $ratingSummary ? $ratingSummary->getRatingSummary() : 0,
            'reviews_count' => $reviewsCount
        ];
    }

    /**
     * Get product options
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return array
     */
    public function getProductOptions($product)
    {
        $options = ['colors' => [], 'sizes' => [], 'otherOptions' => [], 'attributeIds' => []];

        if ($product->getTypeId() == 'configurable') {
            $configurableAttributes = $product->getTypeInstance()->getConfigurableAttributes($product);
            $usedProducts = $product->getTypeInstance()->getUsedProducts($product);

            // Build map of option values to child products
            $optionProductsMap = [];
            foreach ($usedProducts as $child) {
                foreach ($configurableAttributes as $attribute) {
                    $attrCode = $attribute->getProductAttribute()->getAttributeCode();
                    $attrValue = $child->getData($attrCode);
                    if ($attrValue) {
                        if (!isset($optionProductsMap[$attrCode][$attrValue])) {
                            $optionProductsMap[$attrCode][$attrValue] = [];
                        }
                        $optionProductsMap[$attrCode][$attrValue][] = $child;
                    }
                }
            }

            foreach ($configurableAttributes as $attribute) {
                $attributeCode = $attribute->getProductAttribute()->getAttributeCode();
                $attributeLabel = $attribute->getProductAttribute()->getFrontendLabel();
                $attributeId = $attribute->getAttributeId();
                $productAttribute = $attribute->getProductAttribute();

                // Check if this is a swatch attribute
                $isVisualSwatch = $this->swatchHelper->isVisualSwatch($productAttribute);
                $isTextSwatch = $this->swatchHelper->isTextSwatch($productAttribute);

                $attributeOptions = [];
                $optionIds = [];

                foreach ($attribute->getOptions() as $option) {
                    if ($option['value_index']) {
                        $optionIds[] = $option['value_index'];
                        $attributeOptions[] = [
                            'id' => $option['value_index'],
                            'label' => $option['label'],
                            'value' => $option['value_index']
                        ];
                    }
                }

                // Get swatch data for options
                if ($isVisualSwatch || $isTextSwatch) {
                    $swatches = $this->swatchHelper->getSwatchesByOptionsId($optionIds);

                    foreach ($attributeOptions as &$opt) {
                        if (isset($swatches[$opt['id']])) {
                            $swatchData = $swatches[$opt['id']];
                            $opt['swatch_type'] = $swatchData['type'];
                            $opt['swatch_value'] = $swatchData['value'];

                            // For visual swatches (color swatches)
                            if ($swatchData['type'] == '1') { // Visual swatch (color)
                                $opt['swatch_color'] = $swatchData['value'];
                            } elseif ($swatchData['type'] == '2') { // Visual swatch (image)
                                $opt['swatch_thumb'] = $this->swatchMediaHelper->getSwatchAttributeImage('swatch_thumb', $swatchData['value']);
                            } elseif ($swatchData['type'] == '0') { // Text swatch
                                $opt['swatch_text'] = $swatchData['value'];
                            }
                        }

                        // Get image for this option
                        if (isset($optionProductsMap[$attributeCode][$opt['id']])) {
                            $childProduct = $optionProductsMap[$attributeCode][$opt['id']][0];
                            $opt['image'] = $this->imageHelper->init($childProduct, 'product_base_image')->getUrl();
                        }
                    }
                }

                // Categorize by attribute code
                if (strtolower($attributeCode) == 'color') {
                    $options['colors'] = $attributeOptions;
                    $options['attributeIds']['color'] = $attributeId;
                } elseif (strtolower($attributeCode) == 'size') {
                    $options['sizes'] = $attributeOptions;
                    $options['attributeIds']['size'] = $attributeId;
                } else {
                    $options['otherOptions'][$attributeCode] = [
                        'label' => $attributeLabel,
                        'options' => $attributeOptions,
                        'id' => $attributeId
                    ];
                    $options['attributeIds'][$attributeCode] = $attributeId;
                }
            }
        }

        return $options;
    }
}
