<?php
/**
 * Edit Comment Item (no new comment creation allowed)
 */
namespace DreamSites\Blog\Controller\Adminhtml\CommentList;

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
     * Initialize Group Controller
     *
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
        return $this->_authorization->isAllowed('DreamSites_Blog::pagelist');
    }

    /**
     * Edit CommentList item.
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $commentId = $this->getRequest()->getParam('comment_id');

        // If no comment ID, redirect back to list (we don't allow creating new comments)
        if ($commentId === null) {
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            $this->messageManager->addError(__('Cannot create new comments. You can only edit existing comments.'));
            return $resultRedirect->setPath('*/*/');
        }

        $this->_coreRegistry->register('current_comment_id', $commentId);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        $resultPage->addBreadcrumb(__('Edit Comment'), __('Edit Comment'));
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Comment'));

        $resultPage->getLayout()
            ->addBlock('DreamSites\Blog\Block\Adminhtml\Comment\Edit', 'commentlist', 'content')
            ->setEditMode((bool)$commentId);

        return $resultPage;
    }
}
