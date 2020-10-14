<?php
namespace DreamSites\ReferaFriend\Block;
 
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\SalesRule\Model\Rule;

class ReferaFriend extends \Magento\Framework\View\Element\Template
{    
    const DISCOUNT_ACTION_BY_PERCENT = 'by_percent';
    const DISCOUNT_ACTION_FIXED_AMOUNT = 'by_fixed';
    const DISCOUNT_ACTION_FIXED_AMOUNT_FOR_CART = 'cart_fixed';
    const DISCOUNT_ACTION_BUY_X_GET_Y = 'buy_x_get_y';

    protected $scopeConfig;

    protected $rule;

    protected $_referColFactory;

    protected $_referCollection;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Rule $rule,
        \Magento\Framework\View\Element\Template\Context $context,
        \DreamSites\ReferaFriend\Model\ResourceModel\Refer\CollectionFactory $collectionFactory
    ) {
        $this->_referColFactory = $collectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->rule = $rule;
        parent::__construct($context, []);
    }

    public function getFormActionUrl()
    {
    	//change this to secure when launching live
        return $this->getUrl('referafriend/index/refer', array('_secure' => false));
    }

    public function getStoreName()
	{
	    return $this->_scopeConfig->getValue(
	        'general/store_information/name',
	        \Magento\Store\Model\ScopeInterface::SCOPE_STORE
	    );
	}

    public function getCouponAction()
    {
        $ruleId = $this->scopeConfig->getValue('referafriendadmin/general/cart_price_rule_id', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
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

    public function getBackgroundImage()
    {

    }

}