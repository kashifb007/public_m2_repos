<?php
/**
 * Edit comment item form
 */
namespace DreamSites\Blog\Block\Adminhtml\Comment\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{

    /**
     * @var \DreamSites\Blog\Model\CommentFactory
     */
    protected $commentDataFactory;

    /**
     * @var \DreamSites\Blog\Model\PageFactory
     */
    protected $pageDataFactory;

    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $timezone;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \DreamSites\Blog\Model\CommentFactory $commentDataFactory
     * @param \DreamSites\Blog\Model\PageFactory $pageDataFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \DreamSites\Blog\Model\CommentFactory $commentDataFactory,
        \DreamSites\Blog\Model\PageFactory $pageDataFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        array $data = []
    ) {
        $this->commentDataFactory = $commentDataFactory;
        $this->pageDataFactory = $pageDataFactory;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->timezone = $timezone;
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

        $commentId = $this->_coreRegistry->registry('current_comment_id');

        // Initialize commentData
        if ($commentId !== null) {
            $commentData = $this->commentDataFactory->create()->load($commentId);
        } else {
            $commentData = $this->commentDataFactory->create();
        }

        $yesNo = [];
        $yesNo[0] = 'No';
        $yesNo[1] = 'Yes';

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Comment Information')]);

        // Load blog page data to get the title
        $blogTitle = '';
        if ($commentData->getPageId()) {
            $pageData = $this->pageDataFactory->create()->load($commentData->getPageId());
            $blogTitle = $pageData->getTitle();
        }

        $fieldset->addField(
            'page_title',
            'text',
            [
                'name' => 'page_title',
                'label' => __('Blog Title'),
                'title' => __('Blog Title'),
                'value' => $blogTitle,
                'readonly' => true,
                'disabled' => true,
                'note' => __('The blog post this comment belongs to.')
            ]
        );

        $fieldset->addField(
            'author_name',
            'text',
            [
                'name' => 'author_name',
                'label' => __('Author'),
                'title' => __('Author'),
                'required' => true,
                'readonly' => true,
                'disabled' => true,
            ]
        );

        $fieldset->addField(
            'author_email',
            'textarea',
            [
                'name' => 'author_email',
                'label' => __('Email'),
                'title' => __('Email'),
                'required' => true,
                'readonly' => true,
                'disabled' => true,
            ]
        );

        $fieldset->addField(
            'content',
            'textarea',
            [
                'name' => 'content',
                'label' => __('Comment'),
                'title' => __('Comment'),
                'required' => true,
                'readonly' => true,
                'disabled' => true,
            ]
        );

        $fieldset->addField(
            'is_approved',
            'select',
            [
                'name' => 'is_approved',
                'label' => __('Approved'),
                'title' => __('Approved'),
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
                'label' => __('Comment Date'),
                'title' => __('Comment Date'),
                'readonly' => true,
                'disabled' => true,
            ]
        );

        if ($commentData->getId() !== null) {
            // If edit add id
            $form->addField('comment_id', 'hidden', ['name' => 'comment_id', 'value' => $commentData->getId()]);
        }

        if ($this->_backendSession->getCommentData()) {
            $form->addValues($this->_backendSession->getCommentData());
            $this->_backendSession->setCommentData(null);
        } else {
            // Format the created_at date to user-friendly format
            $createdAt = $commentData->getCreatedAt();
            if ($createdAt) {
                $formattedDate = $this->timezone->date(new \DateTime($createdAt))->format('j M Y H:i:s');
            } else {
                $formattedDate = '';
            }

            $form->addValues(
                [
                    'id' => $commentData->getCommentId(),
                    'author_name' => $commentData->getAuthorName(),
                    'author_email' => $commentData->getAuthorEmail(),
                    'content' => $commentData->getContent(),
                    'is_approved' => $commentData->getIsApproved(),
                    'created_at' => $formattedDate,
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
