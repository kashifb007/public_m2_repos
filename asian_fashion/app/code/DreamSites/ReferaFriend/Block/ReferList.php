<?php
namespace DreamSites\ReferaFriend\Block;

use DreamSites\ReferaFriend\Model\ResourceModel\Refer\CollectionFactory;
use Magento\Framework\View\Element\Template;
use DreamSites\ReferaFriend\Model\ResourceModel\Refer\Collection as ReferCollection;
use Magento\Store\Model\ScopeInterface;

class ReferList extends Template
{

    /**
     * @var CollectionFactory
     */
    protected $_referColFactory;

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
        $this->_referColFactory = $collectionFactory;
        $this->removeButton('add');
        parent::__construct(
            $context,
            $data
        );
    }

} 