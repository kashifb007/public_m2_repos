<?php
/**
 *
 * Filter.php
 *
 * 30/01/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */
namespace Ukpos\KnowledgeHub\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Ukpos\KnowledgeHub\Model\ResourceModel\Tag\Collection as TagCollection;
use Ukpos\KnowledgeHub\Model\ResourceModel\Tag\CollectionFactory;

class Filter extends Template
{

    protected $tagCollection;

    protected $tagColFactory;

    protected $tagColletion;

    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        TagCollection $tagCollection,
        array $data = []
    )
    {
        $this->tagColFactory = $collectionFactory;
        $this->tagCollection = $tagCollection;
        parent::__construct(
            $context,
            $data
        );
    }


    public function getTags()
    {
        if (null === $this->tagCollection) {
            $this->tagCollection = $this->tagColFactory->create();
        }

        $this->tagColletion = $this->tagCollection;
        $this->tagColletion->setOrder('tag','ASC');

        return $this->tagColletion;
    }


}