<?php
/**
 * Controller to render [url]/melza/index/index
 *
 * @package Genmato_Melza
 * @author  Vladimir Kerkhoff <support@genmato.com>
 * @created 2015-11-12
 * @copyright Copyright (c) 2015 Genmato BV, https://genmato.com.
 */
namespace Melza\Imageupload\Controller\Index;

use Magento\Framework\App\Action\Action;

class Index extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Renders Melza Index
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
} 
