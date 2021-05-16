<?php

namespace DreamSites\ReferaFriend\Block;

use DreamSites\ReferaFriend\Model\ResourceModel\Refer\CollectionFactory;
use Magento\Framework\View\Element\Template;

class ReferList extends Template
{

    /**
     * @var CollectionFactory CollectionFactory
     */
    protected $referColFactory;

    /**
     * ReferList constructor.
     * @param Template\Context $context
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->referColFactory = $collectionFactory;
        $this->removeButton('add');
        parent::__construct(
            $context,
            $data
        );
    }
}
