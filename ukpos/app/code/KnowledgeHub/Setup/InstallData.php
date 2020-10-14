<?php
/**
 *
 * InstallData.php
 *
 * 31/01/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $tagData = [
            ['tag' => 'Consumer behaviour'],
            ['tag' => 'Wayfinding'],
            ['tag' => 'Public sector'],
            ['tag' => 'Retailing'],
            ['tag' => 'Corporate'],
            ['tag' => 'Education'],
            ['tag' => 'Hospitality industries'],
            ['tag' => 'Store design'],
            ['tag' => 'Store atmosphere'],
            ['tag' => 'Window displays'],
            ['tag' => 'Visual merchandising'],
            ['tag' => 'Digital'],
            ['tag' => 'Customer loyalty'],
            ['tag' => 'Retail trends'],
            ['tag' => 'Sales'],
            ['tag' => 'Advertising'],
            ['tag' => 'Branding'],
            ['tag' => 'Ethical consumerism'],
            ['tag' => 'Store interior'],
            ['tag' => 'Store exterior'],
            ['tag' => 'Product guides'],
            ['tag' => 'Industry guides']
        ];
        if (version_compare($context->getVersion(), '0.1.1', '<')) {
            foreach ($tagData as $bind) {
                $setup->getConnection()
                    ->insertForce($setup->getTable('ukpos_knowledgehub_tag'), $bind);
            }
        }
    }

}