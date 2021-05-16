<?php

namespace DreamSites\ReferaFriend\Observer;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\SalesRule\Model\Rule;

class ConfigObserver implements ObserverInterface
{

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Rule
     */
    protected $rule;

    /**
     * ConfigObserver constructor.
     * @param ManagerInterface $messageManager
     * @param ScopeConfigInterface $scopeConfig
     * @param Rule $rule
     */
    public function __construct(
        ManagerInterface $messageManager,
        ScopeConfigInterface $scopeConfig,
        Rule $rule
    ) {
        $this->messageManager = $messageManager;
        $this->rule = $rule;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param EventObserver $observer
     */
    public function execute(EventObserver $observer)
    {
        $ruleId = $this->scopeConfig->getValue('referafriendadmin/general/cart_price_rule_id', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $rule = $this->rule->load($ruleId);

        //perform validation checks on the selected cart price rule
        $description = $rule->getDescription();
        $isActive = $rule->getisActive();
        $fromDate = $rule->getFromDate();
        $toDate = $rule->getToDate();
        $isAuto = $rule->getAutoGeneration();
        $couponType = $rule->getCouponType();
        $usesPerCoupon = $rule->getUsesPerCoupon();
        $usesPerCustomer = $rule->getUsesPerCustomer();
    }
}
