<?php
/**
 * Save page form data
 */
namespace DreamSites\Blog\Controller\Adminhtml\CommentList;

use Magento\Backend\App\Action;

class Save extends Action
{

    /**
     * Page factory
     *
     * @var \DreamSites\Blog\Model\CommentFactory
     */
    private $commentFactory;

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

    protected $_logger;

    /**
     * Initialize Group Controller
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \DreamSites\Blog\Model\CommentFactory $commentFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \DreamSites\Blog\Model\CommentFactory $commentFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Session\SessionManagerInterface $session,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->commentFactory = $commentFactory;
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->_session = $session;
        $this->_logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('DreamSites_Blog::pagelist');
    }

    /**
     * Save CommentList item.
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('comment_id');
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            if ($id !== null) {
                $commentData = $this->commentFactory->create()->load((int)$id);
            } else {
                $commentData = $this->commentFactory->create();
            }
            $data = $this->getRequest()->getParams();
            $savedFilename = $this->_session->getData('uploaded_filename');
            if ($savedFilename !== null) {
                $data['image_filename'] = $savedFilename;
            }

            $commentData->setData($data)->save();
            $this->_session->setData('uploaded_filename', null);

            $this->messageManager->addSuccess(__('Saved Comment.'));
            $resultRedirect->setPath('blog/commentlist');
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_getSession()->setPageData($data);
            // Log the error using Magento's PSR-3 logger
            $this->_logger->error('Save Comment failed: ' . $e->getMessage(), [
                'exception' => $e,
                'file' => __FILE__,
                'line' => __LINE__
            ]);

            $resultRedirect->setPath('blog/commentlist/edit', ['comment_id' => $id]);
        }
        return $resultRedirect;
    }
}
