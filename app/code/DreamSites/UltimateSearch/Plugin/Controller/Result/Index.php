<?php
namespace DreamSites\UltimateSearch\Plugin\Controller\Result;

use Magento\Catalog\Model\Session as AjaxSearchSession;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;

class Index extends Action
{
    /**
     * @var AjaxSearchSession
     */
    private $ajaxSearchSession;

    /**
     * Index constructor.
     * @param Context $context
     * @param AjaxSearchSession $ajaxSearchSession
     */
    public function __construct(
        Context $context,
        AjaxSearchSession $ajaxSearchSession
    )
    {
        $this->ajaxSearchSession = $ajaxSearchSession;
        parent::__construct($context);
    }

    /**
     * @return AjaxSearchSession
     */
    private function getAjaxSearchSession(): AjaxSearchSession
    {
        return $this->ajaxSearchSession;
    }

    public function beforeExecute(): void
    {
        $sort = 'relevance';
        $ajaxSearch = null;

        if(isset($_POST['sort'])) {
            $sort = $_POST['sort'];
        }

        if(isset($_POST['ajax_search'])) {
            $ajaxSearch = $_POST['ajax_search'];
        }

        if($ajaxSearch) {
            $this->getAjaxSearchSession()->setIsAjaxSearch(true);
        } else {
            $this->getAjaxSearchSession()->unsIsAjaxSearch();
        }
        $this->getAjaxSearchSession()->setSort($sort);
    }

    public function execute(): void
    {
        //
    }
}
