<?php
/**
 * Page Collection
 */
namespace DreamSites\HomeCarousel\Model\ResourceModel\Image;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'image_id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('DreamSites\HomeCarousel\Model\Image', 'DreamSites\HomeCarousel\Model\ResourceModel\Image');
    }

    /**
     * @return array
     */
    public function toOptionIdArray()
    {
        $res = [];
        $res[] = ['value'=>'', 'label'=>__('Please Select')];
        foreach ($this as $item) {
            $data['value'] = $item->getData('image_id');
            $data['label'] = $item->getData('title');

            $res[] = $data;
        }

        return $res;
    }
}
