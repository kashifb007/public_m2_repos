<?php
/**
 *
 * Articles.php
 *
 * 31/01/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */
namespace Melza\Imageupload\Model;

use Magento\Framework\Model\AbstractModel;

class Article extends AbstractModel
{

    const CACHE_TAG = 'cms_page';

    protected function _construct()
    {
        $this->_init('Ukpos\KnowledgeHub\Model\ResourceModel\Article');
        parent::_construct();
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

}