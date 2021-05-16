<?php

/**
 ** 15/05/2021
 ** @author Kashif
 **/

namespace DreamSites\ReferaFriend\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\SalesRule\Model\RuleFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class SendCoupons
 * @package DreamSites\ReferaFriend\Model
 **/
class SendCoupons
{

    /**
     * @var RuleFactory
     */
    protected $ruleFactory;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * SendCoupons constructor.
     * @param RuleFactory $ruleFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param LoggerInterface $logger
     * @param TransportBuilder $transportBuilder
     */
    public function __construct(
        RuleFactory $ruleFactory,
        ScopeConfigInterface $scopeConfig,
        LoggerInterface $logger,
        TransportBuilder $transportBuilder
    ) {
        $this->ruleFactory = $ruleFactory;
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
        $this->transportBuilder = $transportBuilder;
    }

    public function generateCoupons(): array
    {
        $ruleId = $this->scopeConfig->getValue('referafriendadmin/general/cart_price_rule_id', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $dashes = $this->scopeConfig->getValue('referafriendadmin/general/dash_every_x_characters', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $rule = $this->ruleFactory->create()->load($ruleId);
        $rule->setCouponType(3);
        $rule->save();
        $newCoupon = $rule->acquireCoupon(true, 1);
        $newCoupon->setType(1);
        $newCoupon->setCreatedAt(date('Y-m-d h:i:s'));
        $newCoupon->setExpirationDate(null);
        $newCoupon->setTimesUsed(0);
        $newCoupon->save();
        $rule->setCouponType(2);
        $rule->setUseAutoGeneration(1);
        $rule->save();

        $couponCode = $newCoupon->getCode();
        $couponLength = strlen($couponCode);
        $couponCode1 = $couponCode;

        if (!empty($dashes) && (int)$dashes < $couponLength) {
            $couponCode1 = '';
            for ($x=1; $x <= $couponLength; $x++) {
                $couponCode1 .= $couponCode[$x-1];
                $remainder = $x % $dashes;
                if ($remainder === 0 && $x >= $dashes && $x !== $couponLength) {
                    $couponCode1 .= '-';
                }
            }
            $newCoupon->setCode($couponCode1);
            $newCoupon->save();
        }

        $rule->setCouponType(3);
        $rule->save();
        $newCoupon = $rule->acquireCoupon(true, 1);
        $newCoupon->setType(1);
        $newCoupon->setCreatedAt(date('Y-m-d h:i:s'));
        $newCoupon->setExpirationDate(null);
        $newCoupon->setTimesUsed(0);
        $newCoupon->save();
        $rule->setCouponType(2);
        $rule->setUseAutoGeneration(1);
        $rule->save();
        $couponCode = $newCoupon->getCode();
        $couponLength = strlen($couponCode);
        $couponCode2 = $couponCode;

        if (!empty($dashes) && (int)$dashes < $couponLength) {
            $couponCode2 = '';
            for ($x=1; $x <= $couponLength; $x++) {
                $couponCode2 .= $couponCode[$x-1];
                $remainder = $x % $dashes;
                if ($remainder === 0 && $x >= $dashes && $x !== $couponLength) {
                    $couponCode2 .= '-';
                }
            }
            $newCoupon->setCode($couponCode2);
            $newCoupon->save();
        }
        return [$couponCode1, $couponCode2];
    }

    public function sendEmails(string $yourEmail, string $yourFirstName, string $friendsEmail, string $friendsName): array
    {
        try {
            //generate the coupon codes
            $couponCodes = $this->generateCoupons();

            $messageData = [
                'coupon_code' => $couponCodes[0],
                'firstname' => $yourFirstName,
                //'storename' => $this->storeManager->getStore()->getName()
                'storename' => 'Asian Fashion'
            ];

            $messageObject = new \Magento\Framework\DataObject();
            $messageObject->setData($messageData);

            //send the email
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('coupon_template')
                ->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID])
                ->setTemplateVars(['data' => $messageObject])
                ->setFrom(['name' => 'Asian Fashion Admin', 'email' => 'magento@dreamsites.co.uk'])
                ->addTo($yourEmail)
                ->getTransport();
            $transport->sendMessage();

            $messageData = [
                'coupon_code' => $couponCodes[1],
                'firstname' => $friendsName,
                //'storename' => $this->storeManager->getStore()->getName()
                'storename' => 'Asian Fashion'
            ];

            $messageObject = new \Magento\Framework\DataObject();
            $messageObject->setData($messageData);

            //send the email
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('coupon_template')
                ->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID])
                ->setTemplateVars(['data' => $messageObject])
                ->setFrom(['name' => 'Asian Fashion Admin', 'email' => 'magento@dreamsites.co.uk'])
                ->addTo($friendsEmail)
                ->getTransport();
            $transport->sendMessage();
        } catch (\Exception $e) {
            $result['content'] = $e->getMessage();
            $this->logger->critical($e);
        }

        return $this->generateCoupons();
    }
}
