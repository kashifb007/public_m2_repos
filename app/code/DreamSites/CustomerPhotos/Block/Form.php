<?php
/**
 * Frontend Form Block
 */
namespace DreamSites\CustomerPhotos\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Messages;

class Form extends Template
{
    /**
     * @var Messages
     */
    protected $messagesBlock;

    /**
     * @param Context $context
     * @param Messages $messagesBlock
     * @param array $data
     */
    public function __construct(
        Context $context,
        Messages $messagesBlock,
        array $data = []
    ) {
        $this->messagesBlock = $messagesBlock;
        parent::__construct($context, $data);
    }

    /**
     * Get messages block
     *
     * @return Messages
     */
    public function getMessagesBlock()
    {
        return $this->messagesBlock;
    }

    /**
     * Get form action URL
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('customerphotos/index/save', ['_secure' => true]);
    }

    /**
     * Get product search URL
     *
     * @return string
     */
    public function getProductSearchUrl()
    {
        return $this->getUrl('customerphotos/index/searchProducts', ['_secure' => true]);
    }

    /**
     * Get filepond upload URL
     *
     * @return string
     */
    public function getUploadUrl()
    {
        return $this->getUrl('customerphotos/index/uploadImage', ['_secure' => true]);
    }
}
