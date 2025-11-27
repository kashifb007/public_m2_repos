<?php
/**
 * Custom field renderer for category tree selector with pills
 *
 * @package DreamSites_NewProducts
 */
namespace DreamSites\NewProducts\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Json\EncoderInterface;

class CategoryTree extends Field
{
    /**
     * @var string
     */
    protected $_template = 'DreamSites_NewProducts::system/config/category_tree.phtml';

    /**
     * @var EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * @param Context $context
     * @param EncoderInterface $jsonEncoder
     * @param array $data
     */
    public function __construct(
        Context $context,
        EncoderInterface $jsonEncoder,
        array $data = []
    ) {
        $this->jsonEncoder = $jsonEncoder;
        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $this->setElement($element);
        return $this->_toHtml();
    }

    /**
     * @return AbstractElement
     */
    public function getElement()
    {
        return $this->getData('element');
    }

    /**
     * @return string
     */
    public function getElementName()
    {
        return $this->getElement()->getName();
    }

    /**
     * @return string
     */
    public function getElementId()
    {
        return $this->getElement()->getHtmlId();
    }

    /**
     * @return array
     */
    public function getSelectedCategories()
    {
        $value = $this->getElement()->getValue();

        if (empty($value)) {
            return [];
        }

        if (is_string($value)) {
            return array_filter(array_map('trim', explode(',', $value)));
        }

        return (array)$value;
    }

    /**
     * @return string
     */
    public function getCategoryChooserUrl()
    {
        return $this->getUrl('newproducts/system_config/categorytree');
    }

    /**
     * @return string
     */
    public function getSelectedCategoriesJson()
    {
        return $this->jsonEncoder->encode($this->getSelectedCategories());
    }
}
