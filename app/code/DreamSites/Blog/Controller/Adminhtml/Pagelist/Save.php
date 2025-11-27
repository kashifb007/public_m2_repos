<?php
/**
 * Save page form data
 */
namespace DreamSites\Blog\Controller\Adminhtml\Pagelist;

use Magento\Backend\App\Action;

class Save extends Action
{

    /**
     * Page factory
     *
     * @var \DreamSites\Blog\Model\PageFactory
     */
    private $pageFactory;

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
     * @param \DreamSites\Blog\Model\PageFactory $pageFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \DreamSites\Blog\Model\PageFactory $pageFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Session\SessionManagerInterface $session,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->pageFactory = $pageFactory;
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
     * Save PageList item.
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('page_id');
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            if ($id !== null) {
                $pageData = $this->pageFactory->create()->load((int)$id);
            } else {
                $pageData = $this->pageFactory->create();
            }
            $data = $this->getRequest()->getParams();
            $savedFilename = $this->_session->getData('uploaded_filename');
            if ($savedFilename !== null) {
                $data['image_filename'] = $savedFilename;
            }

            if (!isset($data['permalink']) || empty($data['permalink'])) {
                // Generate permalink from title if not provided
                $data['permalink'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['title'])));
            } else {
                // Sanitize provided permalink
                $data['permalink'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['permalink'])));
            }

            $pageData->setData($data)->save();
            $this->_session->setData('uploaded_filename', null);

            $this->messageManager->addSuccess(__('Saved Blog Item.'));
            $resultRedirect->setPath('blog/pagelist');
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_getSession()->setPageData($data);
            // Log the error using Magento's PSR-3 logger
            $this->_logger->error('Save Blog Item failed: ' . $e->getMessage(), [
                'exception' => $e,
                'file' => __FILE__,
                'line' => __LINE__
            ]);

            $resultRedirect->setPath('blog/pagelist/edit', ['page_id' => $id]);
        }
        return $resultRedirect;
    }
}
