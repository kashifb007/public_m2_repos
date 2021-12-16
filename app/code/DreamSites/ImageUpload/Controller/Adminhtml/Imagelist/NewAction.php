<?php
/**
 * New Image Item
 *
 * @package DreamSites_ImageUpload
 * @author  Kashif Bhatti <kash@dreamsites.co.uk>
 * @created 01-08-2021
 * @copyright Copyright (c) 2021 Dream Sites, https://www.dreamsites.uk
 */
namespace DreamSites\ImageUpload\Controller\Adminhtml\Imagelist;

use Magento\Backend\App\Action;

/**
 * Class NewAction
 * @package DreamSites\ImageUpload\Controller\Adminhtml\Imagelist
 */
class NewAction extends Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Initialize Group Controller
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('DreamSites_ImageUpload::imagelist');
    }

    /**
     * Edit ImageList item. Forward to new action.
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $imageId = $this->getRequest()->getParam('image_id');
        $this->_coreRegistry->register('current_image_id', $imageId);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        if ($imageId === null) {
            $resultPage->addBreadcrumb(__('New ImageList'), __('New ImageList'));
            $resultPage->getConfig()->getTitle()->prepend(__('New ImageList'));
        } else {
            $resultPage->addBreadcrumb(__('Edit ImageList'), __('Edit ImageList'));
            $resultPage->getConfig()->getTitle()->prepend(__('Edit ImageList'));
        }

        $resultPage->getLayout()
            ->addBlock('DreamSites\ImageUpload\Block\Adminhtml\Image\Edit', 'imagelist', 'content')
            ->setEditMode((bool)$imageId);

        return $resultPage;
    }
}
