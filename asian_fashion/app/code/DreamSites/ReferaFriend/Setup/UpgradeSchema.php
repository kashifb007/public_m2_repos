<?php

namespace DreamSites\ReferaFriend\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.4', '<')) {
            $installer = $setup;
            $installer->startSetup();

            $installer->getConnection()
                ->dropColumn(
                    $installer->getTable('dreamsites_referafriend'),
                    'creation_time'
                );

            $installer->getConnection()
                ->dropColumn(
                    $installer->getTable('dreamsites_referafriend'),
                    'update_time'
                );

            $installer->getConnection()
                ->addColumn(
                    $installer->getTable('dreamsites_referafriend'),
                    'created_at',
                    [
                        'type' => Table::TYPE_TIMESTAMP,
                        'nullable' => false,
                        'comment' => 'Created At'
                    ]
                );

            $installer->getConnection()
                ->addColumn(
                    $installer->getTable('dreamsites_referafriend'),
                    'updated_at',
                    [
                        'type' => Table::TYPE_TIMESTAMP,
                        'nullable' => true,
                        'comment' => 'Updated At'
                    ],
                );

            $installer->getConnection()
                ->addColumn(
                    $installer->getTable('dreamsites_referafriend'),
                    'cart_rule_name',
                    [
                        'type' => Table::TYPE_TEXT,
                        'nullable' => false,
                        'length' => 255,
                        'comment' => 'Cart Rule Name'
                    ]
                );

            $installer->getConnection()
                ->addColumn(
                    $installer->getTable('dreamsites_referafriend'),
                    'discount_amount',
                    [
                        'type' => Table::TYPE_DECIMAL,
                        'nullable' => false,
                        'length' => '12,4',
                        'comment' => 'Discount Amount'
                    ],
                );

            $installer->getConnection()
                ->addColumn(
                    $installer->getTable('dreamsites_referafriend'),
                    'discount_type',
                    [
                        'type' => Table::TYPE_TEXT,
                        'nullable' => false,
                        'length' => 255,
                        'comment' => 'Discount Type'
                    ],
                );

            $installer->endSetup();
        }
    }
}
