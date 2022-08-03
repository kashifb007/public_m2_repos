<?php
namespace DreamSites\UltimateSearch\Block;

class Search extends \Magento\Framework\View\Element\Template
{
    /**
     * @return string
     */
    public function getFormSearchUrl()
    {
        return $this->getUrl('catalogsearch/result/');
    }
}
