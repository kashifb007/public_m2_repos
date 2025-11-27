<?php
/**
 * Page Collection
 */
namespace DreamSites\Blog\Model\ResourceModel\Page;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'page_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('DreamSites\Blog\Model\Page', 'DreamSites\Blog\Model\ResourceModel\Page');
    }

    /**
     * OptionArray for records in dreamsites_blog
     *
     * @return array
     */
    public function toOptionIdArray()
    {
        $res = [];
        $res[] = ['value'=>'', 'label'=>__('Please Select')];
        foreach ($this as $item) {
            $data['value'] = $item->getData('page_id');
            $data['label'] = $item->getData('title');

            $res[] = $data;
        }

        return $res;
    }
}
