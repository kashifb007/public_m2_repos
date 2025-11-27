<?php
/**
 * Controller for getting category names by IDs
 *
 * @package DreamSites_NewProducts
 */
namespace DreamSites\NewProducts\Controller\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class CategoryNames extends Action
{
    /**
    const ADMIN_RESOURCE = 'DreamSites_NewProducts::configuration';

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var CollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param CollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        CollectionFactory $categoryCollectionFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $categoryIds = $this->getRequest()->getParam('category_ids');
        $categories = [];

        if ($categoryIds) {
            $categoryIdsArray = explode(',', $categoryIds);

            $collection = $this->categoryCollectionFactory->create();
            $collection->addAttributeToSelect('name')
                ->addAttributeToFilter('entity_id', ['in' => $categoryIdsArray]);

            foreach ($collection as $category) {
                $categories[$category->getId()] = $category->getName();
            }
        }

        $result = $this->resultJsonFactory->create();
        return $result->setData([
            'success' => true,
            'categories' => $categories
        ]);
    }
}
