<?php
/**
 *
 * Image.php
 *
 * 18/02/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Block\Adminhtml\Article\Helper;


class Image extends \Magento\Framework\Data\Form\Element\Image
{

    protected $_storeManager;

    public function __construct(
        \Magento\Framework\Data\Form\Element\Factory $factoryElement,
        \Magento\Framework\Data\Form\Element\CollectionFactory $factoryCollection,
        \Magento\Framework\Escaper $escaper,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        $data = []
    )
    {
        $this->_storeManager = $storeManager;
        parent::__construct($factoryElement, $factoryCollection, $escaper, $urlBuilder, $data);
    }

    /**
     * @return bool|string
     */
    protected function _getUrl()
    {
        $url = false;
        if ($this->getValue()) {
            $url = $this->_storeManager->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . 'cms_page/upload/' . $this->getValue();
        }
        return $url;
    }
}
