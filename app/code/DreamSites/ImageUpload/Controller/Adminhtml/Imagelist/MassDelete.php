<?php
/**
 * Mass Delete Image Item(s)
 *
 * @package DreamSites_DreamSites
 * @author  Kashif Bhatti <kash@dreamsites.co.uk>
 * @created 01-08-2021
 * @copyright Copyright (c) 2021 DreamSites, https://www.dreamsites.uk
 */
namespace DreamSites\ImageUpload\Controller\Adminhtml\Imagelist;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use DreamSites\ImageUpload\Model\ResourceModel\Image\CollectionFactory;
use Magento\Backend\App\Action;

/**
 * Class MassDelete
 * @package DreamSites\ImageUpload\Controller\Adminhtml\Imagelist
 */
class MassDelete extends Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $item) {
            $item->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
