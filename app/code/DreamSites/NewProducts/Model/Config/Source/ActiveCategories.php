<?php
/**
 * Source model for active categories
 *
 * @package DreamSites_NewProducts
 */
namespace DreamSites\NewProducts\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class ActiveCategories implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * @param CollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        CollectionFactory $categoryCollectionFactory
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * Get options for multiselect
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];

        $collection = $this->categoryCollectionFactory->create();
        $collection->addAttributeToSelect('name')
            ->addAttributeToFilter('is_active', 1)
            ->addAttributeToSort('name', 'ASC')
            ->setOrder('level', 'ASC');

        foreach ($collection as $category) {
            // Skip root category (ID 1) and default category (ID 2)
            if ($category->getId() <= 2) {
                continue;
            }

            $level = (int)$category->getLevel();
            $indent = str_repeat('--', max(0, $level - 2));

            $options[] = [
                'value' => $category->getId(),
                'label' => $indent . ' ' . $category->getName() . ' (ID: ' . $category->getId() . ')'
            ];
        }

        return $options;
    }
}
