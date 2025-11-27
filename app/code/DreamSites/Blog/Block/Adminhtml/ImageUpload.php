<?php

namespace DreamSites\Blog\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;

class ImageUpload extends Template
{
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * Get upload image URL
     *
     * @return string
     */
    public function getUploadImageUrl()
    {
        return $this->getUrl('*/*/saveImage');
    }
}
