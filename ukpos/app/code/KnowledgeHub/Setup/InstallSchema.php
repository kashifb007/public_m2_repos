<?php
/**
 *
 * InstallSchema.php
 *
 * 31/01/2020
 *
 * @author Kashif Bhatti - <kbhatti@ukpos.com>
 *
 */

namespace Ukpos\KnowledgeHub\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();
        if (version_compare($context->getVersion(), '0.1.1', '<') && !$installer->tableExists('ukpos_knowledgehub_tag')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('ukpos_knowledgehub_tags')
            )
                ->addColumn(
                    'tag_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true,
                    ],
                    'Tag ID'
                )
                ->addColumn(
                    'tag',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Tag Name'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    1,
                    ['nullable => false', 'default' => 1],
                    'Tag Status'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At')
                ->setComment('Tags Table');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
    
}