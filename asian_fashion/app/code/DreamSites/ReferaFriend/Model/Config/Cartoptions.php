<?php

namespace DreamSites\ReferaFriend\Model\Config;

use Magento\SalesRule\Model\RuleFactory;
use Magento\Framework\Option\ArrayInterface;

class Cartoptions implements ArrayInterface
{
    /**
     * @var RuleFactory
     */
    private $ruleFactory;

    /**
     * Cartoptions constructor.
     * @param RuleFactory $ruleFactory
     */
    public function __construct(RuleFactory $ruleFactory)
    {
        $this->ruleFactory = $ruleFactory;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $collection = $this->ruleFactory->create()->getCollection();
        $options = [];
        foreach ($collection as $value) {
            $options[] = ['label' => $value->getName(), 'value' => $value->getId()];
        }
        return $options;
    }
}
