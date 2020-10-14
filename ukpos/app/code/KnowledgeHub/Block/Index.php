<?php
/**
 *
 * Index.php
 *
 * 30/01/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */
namespace Ukpos\KnowledgeHub\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;

class Index extends Template
{

    public function __construct(
        Context $context,
        array $data = []
    )
    {
        parent::__construct(
            $context,
            $data
        );
    }
}