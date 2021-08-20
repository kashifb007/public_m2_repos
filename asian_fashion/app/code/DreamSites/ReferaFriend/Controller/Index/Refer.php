<?php

namespace DreamSites\ReferaFriend\Controller\Index;

use DreamSites\ReferaFriend\Model\SendCoupons;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Refer
 * @package DreamSites\ReferaFriend\Controller\Index
 */
class Refer extends \Magento\Framework\App\Action\Action
{
    //referafriend/index/refer

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var SendCoupons
     */
    protected $sendCoupons;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        Context $context,
        SendCoupons $sendCoupons,
        PageFactory $resultPageFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->sendCoupons = $sendCoupons;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute()
    {
        // Form was submitted, perform coupon creation here

        $referEnabled = filter_var($this->scopeConfig->getValue('dreamsites_referafriend/general/refer_enabled'), FILTER_VALIDATE_BOOLEAN);
        if ($referEnabled) {

            $yourEmail = $_POST['email'];
            $yourName = $_POST['firstname'];
            $friendsEmail = $_POST['friends_email'];
            $friendsName = $_POST['friends_name'];

            try {
                $couponCodes = $this->sendCoupons->sendEmails($yourEmail, $yourName, $friendsEmail, $friendsName);

                if (is_array($couponCodes) && count($couponCodes)) {
                    $this->messageManager->addSuccessMessage(
                        __('Thanks for referring a friend to our website. Your friend will receive the coupon code via email and your coupon code is %1', $couponCodes[0])
                    );
                    return $this->resultPageFactory->create();
                } else {
                    $this->messageManager->addWarningMessage(
                        __('Unable to send coupons. Please contact customer services.')
                    );
                    return $this->resultPageFactory->create();
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('Error sending coupons. %1', $e->getMessage())
                );
                return $this->resultPageFactory->create();
            }
        } else {
            $this->messageManager->addErrorMessage(
                __('Refer module is not enabled.')
            );
            return $this->resultPageFactory->create();
        }
    }
}
