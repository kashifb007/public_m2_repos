<?php
/**
 *
 * Index.php
 *
 * 31/01/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->resultPageFactory->create();
    }

}