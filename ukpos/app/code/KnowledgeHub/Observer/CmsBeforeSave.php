<?php
/**
 *
 * CmsBeforeSave.php
 *
 * 14/02/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;


class CmsBeforeSave implements ObserverInterface
{

    public function __construct()
    {
    }

    public function execute(Observer $observer)
    {
        $tags = $observer->getPage()->getTagId();

        if(isset($tags) && !empty($tags)) {
                $tagsCSV = implode(",", $tags);
                $observer->getPage()->setTagId($tagsCSV);
        }else {
            $observer->getPage()->setTagId(NULL);
        }

        $ukDate = explode('/', $observer->getPage()->getSortOrderDate());

        $observer->getPage()->setSortOrderDate($ukDate[2] . '-' . $ukDate[1] . '-' . $ukDate[0]);

    }

}