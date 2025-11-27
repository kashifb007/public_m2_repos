<?php

namespace DreamSites\HomeCarousel\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface   $setup,
                            ModuleContextInterface $context
    )
    {
        $installer = $setup;
        $installer->startSetup();

        /**
         * Create table 'dreamsites_carousel'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('dreamsites_carousel')
        )->addColumn(
            'image_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Image ID'
        )->addColumn(
            'carousel_name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Carousel Name'
        )->addColumn(
            'image_filename',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Image Filename'
        )->addColumn(
            'image_alt',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Image Alt Text'
        )->addColumn(
            'url',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'URL'
        )->addColumn(
            'heading',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Heading'
        )->addColumn(
            'title',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Image Title'
        )->addColumn(
            'button_text',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Button Text'
        )->addColumn(
            'is_active',
            Table::TYPE_SMALLINT,
            1,
            ['nullable' => false, 'unsigned' => true, 'default' => '1'],
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
            'Home Page Carousel Image Upload Table'
        );
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}
