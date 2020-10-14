<?php
/**
 * Admin controller for imagelist grid
 *
 * @package Melza_Imageupload
 * @author  Vladimir Kerkhoff <support@genmato.com>
 * @created 2015-11-13
 * @copyright Copyright (c) 2015 Genmato BV, https://genmato.com.
 */
namespace Melza\Imageupload\Controller\Adminhtml\Imagelist;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action as BackendAction;

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
        return $this->_authorization->isAllowed('Melza_imageupload::imagelist');
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
        $resultPage->setActiveMenu('Melza_imageupload::imagelist');
        $resultPage->addBreadcrumb(__('CMS'), __('CMS'));
        $resultPage->addBreadcrumb(__('Home Images Upload'), __('Home Images Upload'));
        $resultPage->getConfig()->getTitle()->prepend(__('Home Images Upload'));

        return $resultPage;
    }
}