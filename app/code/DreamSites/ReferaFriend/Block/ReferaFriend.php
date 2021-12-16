<?php

namespace DreamSites\ReferaFriend\Block;

use DreamSites\ReferaFriend\Model\ResourceModel\Refer\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\SalesRule\Model\Rule;

class ReferaFriend extends \Magento\Framework\View\Element\Template
{
    public const DISCOUNT_ACTION_BY_PERCENT = 'by_percent';
    public const DISCOUNT_ACTION_FIXED_AMOUNT = 'by_fixed';
    public const DISCOUNT_ACTION_FIXED_AMOUNT_FOR_CART = 'cart_fixed';
    public const DISCOUNT_ACTION_BUY_X_GET_Y = 'buy_x_get_y';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Rule
     */
    protected $rule;

    /**
     * @var CollectionFactory
     */
    protected $referColFactory;

    /**
     * ReferaFriend constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param Rule $rule
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Rule $rule,
        Context $context,
        CollectionFactory $collectionFactory
    ) {
        $this->referColFactory = $collectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->rule = $rule;
        parent::__construct($context, []);
    }

    /**
     * @return string
     */
    public function getFormActionUrl()
    {
        //change this to secure when launching live
        return $this->getUrl('referafriend/index/refer');
    }

    /**
     * @return mixed
     */
    public function getStoreName()
    {
        return $this->scopeConfig->getValue(
            'general/store_information/name',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getCouponAction()
    {
        //TODO update these to system.xml section and group values dreamsites_referafriend
        $ruleId = $this->scopeConfig->getValue('dreamsites_referafriend/general/cart_price_rule_id', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $rule = $this->rule->load($ruleId);

        $ruleAction = (string)$rule->getSimpleAction();
        $discountAmount = (string)$rule->getDiscountAmount();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $priceHelper = $objectManager->create('Magento\Framework\Pricing\Helper\Data');
        $value = number_format($discountAmount, 2);
        $formattedCurrencyValue = $priceHelper->currency($value, true, false);
        $discountAmount = round($discountAmount);

        switch ($ruleAction) {
            case self::DISCOUNT_ACTION_BY_PERCENT:
                return "receive " . $discountAmount . "% off.";
                break;
            case self::DISCOUNT_ACTION_FIXED_AMOUNT:
                return "receive " . $formattedCurrencyValue . " off.";
                break;
            case self::DISCOUNT_ACTION_FIXED_AMOUNT_FOR_CART:
                return "receive " . $formattedCurrencyValue . " off.";
                break;
            case self::DISCOUNT_ACTION_BUY_X_GET_Y:
                return "buy one get one free.";
                break;
            default:
                return "receive " . $discountAmount . "% off.";
                break;
        }
    }

    /**
     *
     */
    public function getBackgroundImage()
    {
    }
}
