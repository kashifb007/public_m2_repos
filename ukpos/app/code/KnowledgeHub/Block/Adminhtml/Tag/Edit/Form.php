<?php
/**
 *
 * Form.php
 *
 * 07/02/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Block\Adminhtml\Tag\Edit;

use Magento\Customer\Controller\RegistryConstants;
use Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{

    /**
     * @var \Ukpos\KnowledgeHub\Model\TagFactory
     */
    protected $tagFactory;
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Ukpos\KnowledgeHub\Model\TagFactory $tagFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Ukpos\KnowledgeHub\Model\TagFactory $tagFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    )
    {
        $this->tagFactory = $tagFactory;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }


    /**
     * @return Generic|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post', 'enctype' => 'multipart/form-data']]
        );

        $tagId = $this->_coreRegistry->registry('current_tag_id');
        /** @var \Ukpos\KnowledgeHub\Model\TagFactory $tagData */
        if ($tagId === null) {
            $tagData = $this->tagFactory->create();
        } else {
            $tagData = $this->tagFactory->create()->load($tagId);
        }

        $yesNo = [];
        $yesNo[0] = 'No';
        $yesNo[1] = 'Yes';

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Basic Information')]);

        $fieldset->addField(
            'tag',
            'text',
            [
                'name' => 'tag',
                'label' => __('Tag'),
                'title' => __('Tag'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'enabled',
            'select',
            [
                'name' => 'enabled',
                'label' => __('Enabled'),
                'title' => __('Enabled'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $yesNo,
            ]
        );

        if ($this->_backendSession->getTagData()) {
            $form->addValues($this->_backendSession->getTagData());
            $this->_backendSession->getTagData(null);
        } else {
            $form->addValues(
                [
                    'tag_id' => $tagData->getId(),
                    'tag' => $tagData->getTag(),
                    'enabled' => $tagData->getEnabled(),
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