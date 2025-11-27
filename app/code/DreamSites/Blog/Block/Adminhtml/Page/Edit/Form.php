<?php
/**
 * Edit page item form
 */
namespace DreamSites\Blog\Block\Adminhtml\Page\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{

    /**
     * @var \DreamSites\Blog\Model\PageFactory
     */
    protected $pageDataFactory;

    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \DreamSites\Blog\Model\PageFactory $pageDataFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \DreamSites\Blog\Model\PageFactory $pageDataFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        array $data = []
    ) {
        $this->pageDataFactory = $pageDataFactory;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @return void
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $pageId = $this->_coreRegistry->registry('current_page_id');
        /** @var \DreamSites\Blog\Model\PageFactory $pageData */
        if ($pageId === null) {
            $pageData = $this->pageDataFactory->create();
        } else {
            $pageData = $this->pageDataFactory->create()->load($pageId);
        }

        $yesNo = [];
        $yesNo[0] = 'No';
        $yesNo[1] = 'Yes';

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Basic Information')]);

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'permalink',
            'text',
            [
                'name' => 'permalink',
                'label' => __('Permalink'),
                'title' => __('Permalink'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'content',
            'editor',
            [
                'name' => 'content',
                'label' => __('Content'),
                'title' => __('Content'),
                'style' => 'height:36em',
                'required' => false,
                'config' => $this->_wysiwygConfig->getConfig()
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
            'has_comments',
            'select',
            [
                'name' => 'has_comments',
                'label' => __('Has Comments'),
                'title' => __('Has Comments'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $yesNo,
            ]
        );

        // Add image upload section
        $imageUploadBlock = $this->getLayout()->createBlock(
            \DreamSites\Blog\Block\Adminhtml\ImageUpload::class,
            'blog_image_upload'
        );
        $imageUploadBlock->setTemplate('DreamSites_Blog::image-upload.phtml');

        $fieldset->addField(
            'image_upload_section',
            'note',
            [
                'label' => __('Blog Image'),
                'text' => $imageUploadBlock->toHtml()
            ]
        );

        $fieldset->addField(
            'image_filename',
            'text',
            [
                'name' => 'image',
                'label' => __('Image Filename'),
                'title' => __('Image Filename'),
                'readonly' => true,
                'note' => __('This field shows the current image filename from the database.')
            ]
        );

        $fieldset->addField(
            'image_alt',
            'text',
            [
                'name' => 'image_alt',
                'label' => __('Image Alt Text'),
                'title' => __('Image Alt Text'),
                'required' => false
            ]
        );

        //if we have image filename show preview
        if ($pageData->getImageFilename() !== null) {
            $imageUrl = $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . 'blog/' . $pageData->getImageFilename();

            $fieldset->addField(
                'image_preview',
                'note',
                [
                    'label' => __('Current Image Preview'),
                    'text' => '<img src="' . $imageUrl . '" alt="' . $pageData->getImageAlt() . '" style="max-width:200px; max-height:200px;" />'
                ]
            );
        }

        if ($pageData->getId() !== null) {
            // If edit add id
            $form->addField('page_id', 'hidden', ['name' => 'page_id', 'value' => $pageData->getId()]);
        }

        if ($this->_backendSession->getPageData()) {
            $form->addValues($this->_backendSession->getPageData());
            $this->_backendSession->setPageData(null);
        } else {
            $form->addValues(
                [
                    'id' => $pageData->getId(),
                    'title' => $pageData->getTitle(),
                    'is_active' => $pageData->getIsActive(),
                    'image_filename' => $pageData->getImageFilename(),
                    'image_alt' => $pageData->getImageAlt(),
                    'content' => $pageData->getContent(),
                    'permalink' => $pageData->getPermalink(),
                    'has_comments' => $pageData->getHasComments(),
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
