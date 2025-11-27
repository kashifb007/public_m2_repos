<?php
/**
 * New Page Item
 */
namespace DreamSites\HomeCarousel\Controller\Adminhtml\Imagelist;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Registry;
use Magento\Framework\Session\SessionManagerInterface;
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
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $_session;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ForwardFactory $resultForwardFactory
     * @param PageFactory $resultPageFactory
     * @param SessionManagerInterface $session
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Session\SessionManagerInterface $session,
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->_session = $session;
        $this->_session->setData('uploaded_filename', null);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('DreamSites_HomeCarousel::imagelist');
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $pageId = $this->getRequest()->getParam('image_id');
        $this->_coreRegistry->register('current_image_id', $pageId);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        if ($pageId === null) {
            $resultPage->addBreadcrumb(__('New Carousel Item'), __('New Carousel Item'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Carousel Item'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Carousel Item'), __('Edit Carousel Item'));
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Carousel Item'));
        }

        $resultPage->getLayout()
            ->addBlock('DreamSites\HomeCarousel\Block\Adminhtml\Image\Edit', 'imagelist', 'content')
            ->setEditMode((bool)$pageId);

        return $resultPage;
    }
}
