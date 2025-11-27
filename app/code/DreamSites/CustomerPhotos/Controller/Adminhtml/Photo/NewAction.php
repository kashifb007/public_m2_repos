<?php
/**
 * Admin New Photo Action
 */
namespace DreamSites\CustomerPhotos\Controller\Adminhtml\Photo;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

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
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ForwardFactory $resultForwardFactory
     * @param PageFactory $resultPageFactory
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
        return $this->_authorization->isAllowed('DreamSites_CustomerPhotos::photo');
    }

    /**
     * Edit Photo item
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
            $resultPage->addBreadcrumb(__('New Customer Photo'), __('New Customer Photo'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Customer Photo'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Customer Photo'), __('Edit Customer Photo'));
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Customer Photo'));
        }

        $resultPage->getLayout()
            ->addBlock('DreamSites\CustomerPhotos\Block\Adminhtml\Image\Edit', 'photo', 'content')
            ->setEditMode((bool)$imageId);

        return $resultPage;
    }
}
