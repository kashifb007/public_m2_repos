<?php

namespace DreamSites\ReferaFriend\Block\Adminhtml\Refer\Edit;

use Magento\Customer\Controller\RegistryConstants;
use Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{

    // protected $_referDataFactory;
    // protected $_systemStore;

    // public function __construct(
    //     \Magento\Backend\Block\Template\Context $context,
    //     \Magento\Framework\Registry $registry,
    //     \Magento\Framework\Data\FormFactory $formFactory,
    //     \DreamSites\ReferaFriend\Model\ReferFactory $referDataFactory,
    //     \Magento\Store\Model\System\Store $systemStore,
    //     array $data = []
    // ) {
    //     $this->_referDataFactory = $referDataFactory;
    //     $this->_systemStore = $systemStore;
    //     parent::__construct($context, $registry, $formFactory, $data);
    // }

    // /**
    //  * Prepare form for render
    //  *
    //  * @return void
    //  */
    // protected function _prepareLayout()
    // {
    //     parent::_prepareLayout();

    //     /** @var \Magento\Framework\Data\Form $form */
    //     //$form = $this->_formFactory->create();
    //     $form = $this->_formFactory->create(
    //         ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post', 'enctype' => 'multipart/form-data']]
    //     );

    //     $referId = $this->_coreRegistry->registry('current_image_id');
    //     if ($referId === null) {
    //         $referData = $this->_referDataFactory->create();
    //     } else {
    //         $referData = $this->_referDataFactory->create()->load($referId);
    //     }

    //     $yesNo = [];
    //     $yesNo[0] = 'No';
    //     $yesNo[1] = 'Yes';

    //     $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Basic Information')]);

    //     $fieldset->addField(
    //         'store_id',
    //         'multiselect',
    //         [
    //             'name' => 'store_id[]',
    //             'label' => __('Store View'),
    //             'title' => __('Store View'),
    //             'required' => true,
    //             'values' => $this->_systemStore->getStoreValuesForForm(false, true),
    //         ]
    //     );

    //     $fieldset->addField(
    //         'email_address',
    //         'text',
    //         [
    //             'name' => 'email_address',
    //             'label' => __('Email Address'),
    //             'email_address' => __('Email Address'),
    //             'required' => false
    //         ]
    //     );

    //     $fieldset->addField(
    //         'friend_email_address',
    //         'text',
    //         [
    //             'name' => 'friend_email_address',
    //             'label' => __("Friend's Email Address"),
    //             'friend_email_address' => __("Friend's Email Address"),
    //             'required' => false
    //         ]
    //     );

    //     $fieldset->addField(
    //         'coupon_code',
    //         'text',
    //         [
    //             'name' => 'coupon_code',
    //             'label' => __('Coupon Code'),
    //             'coupon_code' => __("Coupon Code"),
    //             'required' => false
    //         ]
    //     );

    //     $fieldset->addField(
    //         'discount_amount',
    //         'text',
    //         [
    //             'name' => 'discount_amount',
    //             'label' => __('Discount Amount'),
    //             'discount_amount' => __("Discount Amount"),
    //             'required' => false
    //         ]
    //     );

    //     $fieldset->addField(
    //         'creation_time',
    //         'text',
    //         [
    //             'name' => 'creation_time',
    //             'label' => __('Created Time'),
    //             'creation_time' => __("Created Time"),
    //             'required' => false
    //         ]
    //     );

    //     $fieldset->addField(
    //         'is_active',
    //         'select',
    //         [
    //             'name' => 'is_active',
    //             'label' => __('Active'),
    //             'title' => __('Active'),
    //             'class' => 'required-entry',
    //             'required' => true,
    //             'values' => $yesNo,
    //         ]
    //     );

    //     if ($referData->getId() !== null) {
    //         // If edit add id
    //         $form->addField('refer_id', 'hidden', ['name' => 'refer_id', 'value' => $referData->getId()]);
    //     }

    //     if ($this->_backendSession->getReferData()) {
    //         $form->addValues($this->_backendSession->getReferData());
    //         $this->_backendSession->setReferData(null);
    //     } else {
    //         $form->addValues(
    //             [
    //                 'id' => $referData->getId(),
    //                 'email_address' => $referData->getEmailAddress(),
    //                 'friend_email_address' => $referData->getFriendEmailAddress(),
    //                 'coupon_code' => $referData->getCouponCode(),
    //                 'discount_amount' => $referData->getDiscountAmount(),
    //                 'is_active' => $referData->getIsActive(),
    //                 'store_id' => $referData->getStoreId(),
    //             ]
    //         );          
    //     }        

    //     $form->setUseContainer(true);
    //     $form->setId('edit_form');
    //     $form->setAction($this->getUrl('*/*/save'));
    //     $form->setMethod('post');
    //     $this->setForm($form);
    // }
}
