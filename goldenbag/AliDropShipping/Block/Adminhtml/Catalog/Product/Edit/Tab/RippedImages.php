<?php

/**
 ** 01/06/2021
 ** @author Kashif
 **/


namespace Dreamsites\AliDropShipping\Block\Adminhtml\Catalog\Product\Edit\Tab;

use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Directory\Helper\Data as DirectoryHelper;

/**
 * Class RippedImages
 * @package Dreamsites\AliRipper\Block\Adminhtml\Catalog\Product\Edit\Tab
 **/
class RippedImages extends \Magento\Backend\Block\Template
{
    /**
     * @var string
     */
    protected $_template = 'Dreamsites_AliDropShipping::imageripper.phtml';

    /**
     * ImageRipper constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        return $this->registry->registry('product');
    }

    /**
     * @return string
     */
    public function getAjaxUrl()
    {
        return $this->getUrl('alidropshipping/system_config/import/');
    }

    /**
     * @return string
     */
    public function getClearUrl()
    {
        return $this->getUrl('alidropshipping/system_config/clear/');
    }
}
