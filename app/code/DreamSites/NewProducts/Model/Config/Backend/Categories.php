<?php
/**
 * Backend model for categories field
 * Converts multiselect array to comma-separated string on save
 * and comma-separated string to array on load
 *
 * @package DreamSites_NewProducts
 */
namespace DreamSites\NewProducts\Model\Config\Backend;

use Magento\Framework\App\Config\Value;

class Categories extends Value
{
    /**
     * Convert array to comma-separated string
     *
     * @return $this
     */
    public function beforeSave()
    {
        $value = $this->getValue();

        if (is_array($value)) {
            // Convert array to comma-separated string
            $value = implode(',', $value);
            $this->setValue($value);
        }

        return parent::beforeSave();
    }

    /**
     * Convert comma-separated string to array for multiselect
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        $value = $this->getValue();

        if ($value && !is_array($value)) {
            // Convert comma-separated string to array
            $value = explode(',', $value);
            // Remove empty values and trim whitespace
            $value = array_filter(array_map('trim', $value));
            $this->setValue($value);
        }

        return parent::_afterLoad();
    }
}
