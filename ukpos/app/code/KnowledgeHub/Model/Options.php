<?php
/**
 *
 * Options.php
 *
 * 04/02/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Model;

use Magento\Framework\Option\ArrayInterface;

class Options implements ArrayInterface
{
    protected $options;
    protected $tagFactory;
    protected $tag;

    public function __construct(TagFactory $tagFactory, Tag $tag)
    {
        $this->tagFactory = $tagFactory;
        $this->tag = $tag;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $tagCollection = $this->tagFactory->create();
        $tagCollection = $tagCollection->getCollection();

        $options = [];
        foreach ($tagCollection->getItems() as $tag) {
            $options[] = [
                'label' => $tag->getTag(),
                'value' => $tag->getTagId()
            ];
        }

        //sort tags array alphabetically
        usort($options, function ($a, $b) {
            return strcmp($a["label"], $b["label"]);
        });

        $this->options = $options;

        return $this->options;
    }
}