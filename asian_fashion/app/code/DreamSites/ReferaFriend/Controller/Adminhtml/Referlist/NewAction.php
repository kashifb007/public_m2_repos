<?php
/**
 * New Refer Item
 */
namespace DreamSites\ReferaFriend\Controller\Adminhtml\Referlist;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class NewAction extends Action
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Initialize Group Controller
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ForwardFactory $resultForwardFactory
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ForwardFactory $resultForwardFactory,
        PageFactory $resultPageFactory
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
        return $this->_authorization->isAllowed('DreamSites_ReferaFriend::referlist');
    }

    /**
     * Edit ReferList item. Forward to new action.
     *
     * @return Page|Redirect
     */
    public function execute()
    {
        $referId = $this->getRequest()->getParam('image_id');
        $this->_coreRegistry->register('current_image_id', $referId);

        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        if ($referId === null) {
            $resultPage->addBreadcrumb(__('New ReferList'), __('New ReferList'));
            $resultPage->getConfig()->getTitle()->prepend(__('New ReferList'));
        } else {
            $resultPage->addBreadcrumb(__('Edit ReferList'), __('Edit ReferList'));
            $resultPage->getConfig()->getTitle()->prepend(__('Edit ReferList'));
        }

        $resultPage->getLayout()
            ->addBlock('DreamSites\ReferaFriend\Block\Adminhtml\Refer\Edit', 'referlist', 'content')
            ->setEditMode((bool)$referId);

        return $resultPage;
    }
} 
