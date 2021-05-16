<?php

namespace DreamSites\ReferaFriend\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;

class InstallSchema implements InstallSchemaInterface
{


    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        /**
         * Create table 'dreamsites_referafriend'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('dreamsites_referafriend')
        )->addColumn(
            'refer_id',
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ],
            'Primary ID'
        )->addColumn(
            'cart_rule_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            "Cart Rule ID which contains the coupon codes and cart price rules"
        )->addColumn(
            'email_address',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Email address'
        )->addColumn(
            'friend_email_address',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            "Friend's email address"
        )->addColumn(
            'coupon_code',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Coupon Code'
        )->addColumn(
            'creation_time',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false],
            'Creation Time'
        )->addColumn(
            'update_time',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => true],
            'Modification Time'
        )->addColumn(
            'is_active',
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Is Active'
        )->setComment(
            'Dream Sites Refer a Friend Table'
        );
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}
