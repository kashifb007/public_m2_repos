<?php
/**
 * Block for rendering category tree chooser
 *
 * @package DreamSites_NewProducts
 */
namespace DreamSites\NewProducts\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Data\Tree;

class CategoryChooser extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * @var array
     */
    protected $selectedCategories = [];

    /**
     * @param Context $context
     * @param CollectionFactory $categoryCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $categoryCollectionFactory,
        array $data = []
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function getSelectedCategories()
    {
        if (empty($this->selectedCategories)) {
            $selected = $this->getRequest()->getParam('selected', '');
            $this->selectedCategories = $selected ? explode(',', $selected) : [];
        }
        return $this->selectedCategories;
    }

    /**
     * @return array
     */
    public function getCategoryTree()
    {
        $collection = $this->categoryCollectionFactory->create();
        $collection->addAttributeToSelect(['name', 'is_active'])
            ->addAttributeToFilter('is_active', 1)
            ->addAttributeToSort('position', 'ASC');

        $categories = [];
        foreach ($collection as $category) {
            $categories[$category->getId()] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'parent_id' => $category->getParentId(),
                'level' => $category->getLevel()
            ];
        }

        return $this->buildTree($categories, 1);
    }

    /**
     * @param array $categories
     * @param int $parentId
     * @return array
     */
    protected function buildTree(array $categories, $parentId = 1)
    {
        $tree = [];

        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $children = $this->buildTree($categories, $category['id']);
                if ($children) {
                    $category['children'] = $children;
                }
                $tree[] = $category;
            }
        }

        return $tree;
    }

    /**
     * @param int $categoryId
     * @return bool
     */
    public function isSelected($categoryId)
    {
        return in_array($categoryId, $this->getSelectedCategories());
    }

    /**
     * @param array $categories
     * @param int $level
     * @return string
     */
    public function renderCategoryTree($categories, $level = 0)
    {
        $html = '<ul class="category-tree-list' . ($level === 0 ? ' root-level' : '') . '">';

        foreach ($categories as $category) {
            $hasChildren = !empty($category['children']);
            $isSelected = $this->isSelected($category['id']);

            $html .= '<li class="category-tree-item' . ($hasChildren ? ' has-children' : '') . '" data-category-id="' . $this->escapeHtmlAttr($category['id']) . '">';

            if ($hasChildren) {
                $html .= '<span class="category-toggle">▶</span>';
            } else {
                $html .= '<span class="category-toggle-spacer"></span>';
            }

            $html .= '<label class="category-label">';
            $html .= '<input type="checkbox"
                             class="category-checkbox"
                             value="' . $this->escapeHtmlAttr($category['id']) . '"
                             data-category-name="' . $this->escapeHtmlAttr($category['name']) . '"' .
                             ($isSelected ? ' checked="checked"' : '') . ' />';
            $html .= '<span class="category-name">' . $this->escapeHtml($category['name']) . '</span>';
            $html .= '</label>';

            if ($hasChildren) {
                $html .= $this->renderCategoryTree($category['children'], $level + 1);
            }

            $html .= '</li>';
        }

        $html .= '</ul>';
        return $html;
    }
}
