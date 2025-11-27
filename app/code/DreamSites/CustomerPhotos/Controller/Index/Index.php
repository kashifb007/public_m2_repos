<?php
/**
 * Frontend Form Controller
 */
namespace DreamSites\CustomerPhotos\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $_session;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param SessionManagerInterface $session
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Framework\Session\SessionManagerInterface $session,
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
        $this->_session = $session;
        $this->_session->setData('uploaded_photo', null); // Clear any previous uploaded photo data
    }

    /**
     * Display customer photo upload form
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Upload Your Photo'));
        return $resultPage;
    }
}
