<?php
/**
 *
 * UpgradeSchema.php
 *
 * 30/01/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '0.1.1', '<')) {
            $connection = $setup->getConnection();

            $column = [
                'type' => Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'comment' => 'comma separated list of tags for this cms page',
                'default' => null
            ];
            $connection->addColumn($setup->getTable('cms_page'),
                'tag_id', $column);

            $column = [
                'type' => Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'comment' => 'CMS Image',
                'default' => null
            ];
            $connection->addColumn($setup->getTable('cms_page'),
                'image', $column);

            $column = [
                'type' => Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'comment' => 'Author',
                'default' => null
            ];
            $connection->addColumn($setup->getTable('cms_page'),
                'author', $column);

            $column = [
                'type' => Table::TYPE_TEXT,
                'length' => 1024,
                'nullable' => true,
                'comment' => 'Short description',
                'default' => null
            ];
            $connection->addColumn($setup->getTable('cms_page'),
                'stand_first', $column);

            $column = [
                'type' => Table::TYPE_DATE,
                'nullable' => true,
                'comment' => 'Sort Order Date',
                'default' => null
            ];
            $connection->addColumn($setup->getTable('cms_page'),
                'sort_order_date', $column);
        }

        if (version_compare($context->getVersion(), '0.1.4', '<')) {
            $connection = $setup->getConnection();

            $column = [
                'type' => Table::TYPE_SMALLINT,
                'nullable' => false,
                'comment' => 'Enabled',
                'default' => 1
            ];
            $connection->addColumn($setup->getTable('ukpos_knowledgehub_tag'),
                'enabled', $column);

        }

        $setup->endSetup();
    }
}