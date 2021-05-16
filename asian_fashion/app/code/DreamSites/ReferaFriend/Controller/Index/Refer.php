<?php

namespace DreamSites\ReferaFriend\Controller\Index;

use DreamSites\ReferaFriend\Model\SendCoupons;
use Magento\Framework\App\Action\Context;
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

    public function __construct(
        Context $context,
        SendCoupons $sendCoupons,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->sendCoupons = $sendCoupons;
    }

    public function execute()
    {
        // Form was submitted, perform coupon creation here

        $yourEmail = $_POST['email'];
        $yourFirstName = $_POST['firstname'];
        $yourSurname = $_POST['lastname'];
        $friendsEmail = $_POST['friends_email'];
        $friendsName = $_POST['friends_name'];

        try {
            $couponCodes = $this->sendCoupons->sendEmails($yourEmail, $yourFirstName, $friendsEmail, $friendsName);

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
    }
}
