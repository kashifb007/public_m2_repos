<?php
/**
 * Controller for rendering category tree in modal
 *
 * @package DreamSites_NewProducts
 */
namespace DreamSites\NewProducts\Controller\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class CategoryTree extends Action
{
    /**
    const ADMIN_RESOURCE = 'DreamSites_NewProducts::configuration';

    /**
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Layout $resultLayout */
        $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
        return $resultLayout;
    }
}
