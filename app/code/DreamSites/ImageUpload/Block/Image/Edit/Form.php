<?php
/**
 * Edit image item form
 *
 * @package DreamSites_ImageUpload
 * @author  Kashif Bhatti <kash@dreamsites.co.uk>
 * @created 01-08-2021
 * @copyright Copyright (c) 2021 Dream Sites, https://www.dreamsites.uk
 */
namespace DreamSites\ImageUpload\Block\Adminhtml\Image\Edit;

use Magento\Customer\Controller\RegistryConstants;
use Magento\Backend\Block\Widget\Form\Generic;

/**
 * Class Form
 * @package DreamSites\ImageUpload\Block\Adminhtml\Image\Edit
 */
class Form extends Generic
{

    protected $imageDataFactory;
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \DreamSites\ImageUpload\Model $imageDataFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \DreamSites\ImageUpload\Model\ImageFactory $imageDataFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->imageDataFactory = $imageDataFactory;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form for render
     *
     * @return void
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        /** @var \Magento\Framework\Data\Form $form */
        //$form = $this->_formFactory->create();
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post', 'enctype' => 'multipart/form-data']]
        );

        $imageId = $this->_coreRegistry->registry('current_image_id');
        /** @var \DreamSites\ImageUpload\Model\ImageFactory $imageData */
        if ($imageId === null) {
            $imageData = $this->imageDataFactory->create();
        } else {
            $imageData = $this->imageDataFactory->create()->load($imageId);
        }

        $yesNo = [];
        $yesNo[0] = 'No';
        $yesNo[1] = 'Yes';

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Basic Information')]);

        $fieldset->addField(
                'store_id',
                'multiselect',
                [
                    'name' => 'store_id[]',
                    'label' => __('Store View'),
                    'title' => __('Store View'),
                    'required' => true,
                    'values' => $this->_systemStore->getStoreValuesForForm(false, true),

            ]
        );

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'url',
            'text',
            [
                'name' => 'url',
                'label' => __('URL'),
                'title' => __('URL'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'image_identifier',
            'text',
            [
                'name' => 'image_identifier',
                'label' => __('Image Identifier'),
                'title' => __('Image Identifier'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'filename',
            'image',
            [
                'name' => 'filename',
                'label' => __('Image'),
                'title' => __('Image'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'is_active',
            'select',
            [
                'name' => 'is_active',
                'label' => __('Active'),
                'title' => __('Active'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $yesNo,
            ]
        );

        if ($imageData->getId() !== null) {
            // If edit add id
            $form->addField('image_id', 'hidden', ['name' => 'image_id', 'value' => $imageData->getId()]);
        }

        if ($this->_backendSession->getImageData()) {
            $form->addValues($this->_backendSession->getImageData());
            $this->_backendSession->setImageData(null);
        } else {
            $form->addValues(
                [
                    'id' => $imageData->getId(),
                    'title' => $imageData->getTitle(),
                    'image_identifier' => $imageData->getImageIdentifier(),
                    'filename' => '/home/'.$imageData->getFilename(),
                    'is_active' => $imageData->getIsActive(),
                    'store_id' => $imageData->getStoreId(),
                    'url' => $imageData->getUrl(),
                ]
            );
        }

        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('*/*/save'));
        $form->setMethod('post');
        $this->setForm($form);
    }
}
