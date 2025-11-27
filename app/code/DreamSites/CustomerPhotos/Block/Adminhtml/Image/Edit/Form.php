<?php
/**
 * Edit image item form
 */
namespace DreamSites\CustomerPhotos\Block\Adminhtml\Image\Edit;

use DreamSites\CustomerPhotos\Model\ImageFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Form extends Generic
{
    protected $imageDataFactory;
    protected $productRepository;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param ImageFactory $imageDataFactory
     * @param ProductRepositoryInterface $productRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \DreamSites\CustomerPhotos\Model\ImageFactory $imageDataFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        $this->imageDataFactory = $imageDataFactory;
        $this->productRepository = $productRepository;
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
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $imageId = $this->_coreRegistry->registry('current_image_id');
        /** @var \DreamSites\CustomerPhotos\Model\ImageFactory $imageData */
        if ($imageId === null) {
            $imageData = $this->imageDataFactory->create();
        } else {
            $imageData = $this->imageDataFactory->create()->load($imageId);
        }

        $yesNo = [];
        $yesNo[0] = 'No';
        $yesNo[1] = 'Yes';

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Customer Photo Information')]);

        $fieldset->addField(
            'customer_name',
            'text',
            [
                'name' => 'customer_name',
                'label' => __('Customer Name'),
                'title' => __('Customer Name'),
                'required' => true
            ]
        );

        if ($imageData->getImageFilename() !== null) {
            $imageUrl = $this->_storeManager->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . 'photos/' . $imageData->getImageFilename();

            $fieldset->addField(
                'image_preview',
                'note',
                [
                    'label' => __('Current Image Preview'),
                    'text' => '<img src="' . $imageUrl . '" alt="' . $imageData->getImageFilename() . '" style="max-width:200px; max-height:200px;" />'
                ]
            );
        }

        $fieldset->addField(
            'image_filename',
            'text',
            [
                'name' => 'image_filename',
                'label' => __('Image Filename'),
                'title' => __('Image Filename'),
                'required' => true,
                'readonly' => true,
                'disabled' => true,
            ]
        );

        $fieldset->addField(
            'instagram',
            'text',
            [
                'name' => 'instagram',
                'label' => __('Instagram Handle'),
                'title' => __('Instagram Handle'),
                'required' => false
            ]
        );

        // Display product name as a note field
        if ($imageData->getProductId()) {
            try {
                $product = $this->productRepository->getById($imageData->getProductId());
                $productName = $product->getName();
                $productImage = $product->getThumbnail();
                $imageUrl = $this->_storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . 'catalog/product/' . $productImage;

                $fieldset->addField(
                    'product_name_display',
                    'note',
                    [
                        'label' => __('Product'),
                        'text' => '<img title="' . $productName . '" src="' . $imageUrl . '" alt="' . $productName . '" style="max-width:200px; max-height:200px;" />'
                    ]
                );
            } catch (\Exception $e) {
                $fieldset->addField(
                    'product_name_display',
                    'note',
                    [
                        'label' => __('Product'),
                        'text' => __('Product ID: %1 (Product not found)', $imageData->getProductId())
                    ]
                );
            }
        } else {
            // If no product selected (shouldn't happen, but handle it)
            $fieldset->addField(
                'product_name_display',
                'note',
                [
                    'label' => __('Product'),
                    'text' => __('No product selected')
                ]
            );
        }

        if ($imageData->getProductId() && !empty($productName)) {
            $fieldset->addField(
                'product_chosen',
                'text',
                [
                    'name' => 'image_filename',
                    'label' => __('Product Name'),
                    'title' => __('Product Name'),
                    'required' => false,
                    'readonly' => true,
                    'disabled' => true,
                    'value' => $productName,
                ]
            );
        }

        //allow admin to change product association
        $fieldset->addField(
            'product_id',
            'text',
            [
                'name' => 'product_id',
                'label' => __('Product ID'),
                'title' => __('Product ID'),
                'required' => true,
                'value' => $imageData->getProductId(),
                'min' => 1,
                'class' => 'validate-number',
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
            'created_at',
            'text',
            [
                'name' => 'created_at',
                'label' => __('Created'),
                'title' => __('Created'),
                'required' => false,
                'readonly' => true,
                'disabled' => true,
                'value' => $imageData->getCreatedAt(),
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
                    'customer_name' => $imageData->getCustomerName(),
                    'image_filename' => $imageData->getImageFilename(),
                    'instagram' => $imageData->getInstagram(),
                    'is_active' => $imageData->getIsActive(),
                    'product_id' => $imageData->getProductId(),
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
