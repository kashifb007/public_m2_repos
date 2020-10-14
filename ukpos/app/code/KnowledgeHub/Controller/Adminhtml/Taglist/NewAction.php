<?php
/**
 *
 * NewAction.php
 *
 * 07/02/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Controller\Adminhtml\Taglist;

use Magento\Backend\App\Action;

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
        return $this->_authorization->isAllowed('Ukpos_KnowledgeHub::taglist');
    }

    /**
     * Edit Tag item. Forward to new action.
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $tagId = $this->getRequest()->getParam('tag_id');
        $this->_coreRegistry->register('current_tag_id', $tagId);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        if ($tagId === null) {
            $resultPage->addBreadcrumb(__('New Tag'), __('New Tag'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Tag'));
        }

        $resultPage->getLayout()
            ->addBlock('Ukpos\KnowledgeHub\Block\Adminhtml\Tag\Edit', 'taglist', 'content')
            ->setEditMode((bool)$tagId);

        return $resultPage;
    }
    
}