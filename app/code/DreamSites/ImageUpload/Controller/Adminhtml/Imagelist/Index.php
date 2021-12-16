<?php
/**
 * Admin controller for imagelist grid
 *
 * @package DreamSites_ImageUpload
 * @author  Kashif Bhatti <kash@dreamsites.co.uk>
 * @created 01-08-2021
 * @copyright Copyright (c) 2021 Dream Sites, https://www.dreamsites.uk
 */
namespace DreamSites\ImageUpload\Controller\Adminhtml\Imagelist;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action as BackendAction;

/**
 * Class Index
 * @package DreamSites\ImageUpload\Controller\Adminhtml\Imagelist
 */
class Index extends BackendAction
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    /**
     * Check the permission to run it
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('DreamSites_imageupload::imagelist');
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('DreamSites_imageupload::imagelist');
        $resultPage->addBreadcrumb(__('CMS'), __('CMS'));
        $resultPage->addBreadcrumb(__('Home Images Upload'), __('Home Images Upload'));
        $resultPage->getConfig()->getTitle()->prepend(__('Home Images Upload'));

        return $resultPage;
    }
}
