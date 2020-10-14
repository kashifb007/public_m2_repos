<?php

namespace DreamSites\ReferaFriend\Model\Config;

use Magento\Framework\Option\ArrayInterface;

class Couponoptions implements ArrayInterface
{   

	const COUPON_FORMAT_ALPHANUMERIC = 'alphanum';
    const COUPON_FORMAT_ALPHABETICAL = 'alpha';
    const COUPON_FORMAT_NUMERIC = 'num';

    public function toOptionArray()
    {
        return [
            self::COUPON_FORMAT_ALPHANUMERIC => __('Alphanumeric'),
            self::COUPON_FORMAT_ALPHABETICAL => __('Alphabetical'),
            self::COUPON_FORMAT_NUMERIC => __('Numeric')
        ];
    }
}