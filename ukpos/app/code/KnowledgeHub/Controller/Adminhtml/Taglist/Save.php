<?php
/**
 *
 * Save.php
 *
 * 07/02/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Controller\Adminhtml\Taglist;

use Magento\Backend\App\Action;

class Save extends Action
{

    /**
     * Tag factory
     *
     * @var \Ukpos\KnowledgeHub\Model\TagFactory
     */
    private $tagFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $storeManager;

    protected $dir;

    /**
     * Initialize Group Controller
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Ukpos\KnowledgeHub\Model\TagFactory $tagFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Ukpos\KnowledgeHub\Model\TagFactory $tagFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Filesystem\DirectoryList $dir
    ) {
        $this->context = $context;
        $this->_coreRegistry = $coreRegistry;
        $this->tagFactory = $tagFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->_storeManager = $storeManager;
        $this->_dir = $dir;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Melza_Imageupload::taglist');
    }

    /**
     * Save TagList item.
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('tag_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $data = $this->getRequest()->getParams();

            $tagData = $this->tagFactory->create();
            
            $tagData->setData($data)->save();

            $this->messageManager->addSuccess(__('Saved Tag item.'));
            $resultRedirect->setPath('tag/taglist');
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_getSession()->setTagData($data);

            $resultRedirect->setPath('tag/taglist/edit', ['tag_id' => $id]);
        }
        return $resultRedirect;
    }
    
}