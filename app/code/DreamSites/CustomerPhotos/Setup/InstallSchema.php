<?php

namespace DreamSites\CustomerPhotos\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface   $setup,
                            ModuleContextInterface $context
    )
    {
        $installer = $setup;
        $installer->startSetup();

        /**
         * Create table 'dreamsites_customer_photo'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('dreamsites_customer_photo')
        )->addColumn(
            'image_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Image ID'
        )->addColumn(
            'customer_name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Customer Name'
        )->addColumn(
            'image_filename',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Image Filename'
        )->addColumn(
            'instagram',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Instagram social handle'
        )->addColumn(
            'product_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'unsigned' => true],
            'Product'
        )->addIndex(
            $installer->getIdxName('dreamsites_customer_photo', ['product_id']),
            ['product_id']
        )->addForeignKey(
            $installer->getFkName(
                'dreamsites_customer_photo',
                'product_id',
                'catalog_product_entity',
                'entity_id'
            ),
            'product_id',
            $installer->getTable('catalog_product_entity'),
            'entity_id',
            Table::ACTION_CASCADE
        )->addColumn(
            'is_active',
            Table::TYPE_SMALLINT,
            1,
            ['nullable' => false, 'unsigned' => true, 'default' => '0'], //unapproved by default
            'Is Active'
        )->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            [],
            'Creation Time'
        )->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            [],
            'Modification Time'
        )->setComment(
            'Home Page Customer Photo Upload Table'
        );
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}
