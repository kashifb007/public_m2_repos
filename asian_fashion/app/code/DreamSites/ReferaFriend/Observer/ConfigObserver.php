<?php
namespace DreamSites\ReferaFriend\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;

class ConfigObserver implements ObserverInterface
{


    protected $resultFactory;

    protected $messageManager;

    protected $scopeConfig;

    protected $rule;

    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\SalesRule\Model\Rule $rule
    ) {
        $this->messageManager = $messageManager;  
        $this->rule = $rule;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute(EventObserver $observer)
    {
        $ruleId = $this->scopeConfig->getValue('referafriendadmin/general/cart_price_rule_id', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $rule = $this->rule->load($ruleId);

        //perform validation checks on the selected cart price rule
        $description = $rule->getDescription();;
        $isActive = $rule->getisActive();
        $fromDate = $rule->getFromDate();
        $toDate = $rule->getToDate();
        $isAuto = $rule->getAutoGeneration();
        $couponType = $rule->getCouponType();
        $usesPerCoupon = $rule->getUsesPerCoupon();
        $usesPerCustomer = $rule->getUsesPerCustomer();


        // $this->messageManager->getMessages(true);
        // $message = $couponLength;

        // $this->messageManager->addError($couponLength);
    }
}