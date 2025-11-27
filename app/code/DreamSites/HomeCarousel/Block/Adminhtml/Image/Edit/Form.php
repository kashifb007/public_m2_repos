<?php
/**
 * Edit image item form
 */
namespace DreamSites\HomeCarousel\Block\Adminhtml\Image\Edit;

use DreamSites\HomeCarousel\Model\ImageFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;

class Form extends Generic
{
    protected $imageDataFactory;
    protected $_systemStore;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param ImageFactory $imageDataFactory
     * @param Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \DreamSites\HomeCarousel\Model\ImageFactory $imageDataFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->imageDataFactory = $imageDataFactory;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return void
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post', 'enctype' => 'multipart/form-data']]
        );

        $imageId = $this->_coreRegistry->registry('current_image_id');
        /** @var \DreamSites\HomeCarousel\Model\ImageFactory $imageData */
        if ($imageId === null) {
            $imageData = $this->imageDataFactory->create();
        } else {
            $imageData = $this->imageDataFactory->create()->load($imageId);
        }

        $yesNo = [];
        $yesNo[0] = 'No';
        $yesNo[1] = 'Yes';

        $positions = $imageData->getAvailablePositions();
        $verticalPositions = $imageData->getAvailableVerticalPositions();

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Basic Information')]);

        $fieldset->addField(
            'carousel_name',
            'text',
            [
                'name' => 'carousel_name',
                'label' => __('Carousel Name'),
                'title' => __('Carousel Name'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'heading',
            'text',
            [
                'name' => 'heading',
                'label' => __('Heading'),
                'title' => __('Heading'),
                'required' => false
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
            'button_text',
            'text',
            [
                'name' => 'button_text',
                'label' => __('Button Text'),
                'title' => __('Button Text'),
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

        //if we have image filename show preview
        if ($imageData->getImageFilename() !== null) {
            $imageUrl = $this->_storeManager->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . 'carousel/' . $imageData->getImageFilename();

            $fieldset->addField(
                'image_preview',
                'note',
                [
                    'label' => __('Current Image Preview'),
                    'text' => '<img src="' . $imageUrl . '" alt="' . $imageData->getImageAlt() . '" style="max-width:200px; max-height:200px;" />'
                ]
            );
        }

        $fieldset->addField(
            'image_filename',
            'file',
            [
                'name' => 'image_filename',
                'label' => __('Image'),
                'title' => __('Image'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'image_alt',
            'text',
            [
                'name' => 'image_alt',
                'label' => __('Image Alt'),
                'title' => __('Image Alt'),
                'required' => false
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

        $fieldset->addField(
            'sort_order',
            'text',
            [
                'name' => 'sort_order',
                'label' => __('Sort Order'),
                'title' => __('Sort Order'),
                'required' => true,
                'class' => 'validate-number',
            ]
        );

        $fieldset->addField(
            'position',
            'select',
            [
                'name' => 'position',
                'label' => __('Text Position'),
                'title' => __('Text Position'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $positions,
            ]
        );

        $fieldset->addField(
            'vertical_position',
            'select',
            [
                'name' => 'vertical_position',
                'label' => __('Text Vertical Position'),
                'title' => __('Text Vertical Position'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $verticalPositions,
            ]
        );

        $fieldset->addField(
            'heading_colour',
            'text',
            [
                'name' => 'heading_colour',
                'label' => __('Heading Colour'),
                'title' => __('Heading Colour'),
                'required' => false,
                'note' => 'search "color picker" on Google and select the HEX',
            ]
        );

        $fieldset->addField(
            'title_colour',
            'text',
            [
                'name' => 'title_colour',
                'label' => __('Title Colour'),
                'title' => __('Title Colour'),
                'required' => false,
            ]
        );

        $fieldset->addField(
            'button_colour',
            'text',
            [
                'name' => 'button_colour',
                'label' => __('Button Colour'),
                'title' => __('Button Colour'),
                'required' => false,
            ]
        );

        $fieldset->addField(
            'button_text_colour',
            'text',
            [
                'name' => 'button_text_colour',
                'label' => __('Button Text Colour'),
                'title' => __('Button Text Colour'),
                'required' => false,
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
                    'carousel_name' => $imageData->getCarouselName(),
                    'sort_order' => $imageData->getSortOrder(),
                    'position' => $imageData->getPosition(),
                    'heading' => $imageData->getHeading(),
                    'button_text' => $imageData->getButtonText(),
                    'image_filename' => $imageData->getImageFilename(),
                    'image_alt' => $imageData->getImageAlt(),
                    'is_active' => $imageData->getIsActive(),
                    'url' => $imageData->getUrl(),
                    'button_colour' => $imageData->getButtonColour(),
                    'button_text_colour' => $imageData->getButtonTextColour(),
                    'heading_colour' => $imageData->getHeadingColour(),
                    'title_colour' => $imageData->getTitleColour(),
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
