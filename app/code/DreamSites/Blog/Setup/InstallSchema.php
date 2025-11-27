<?php
/**
 * Create database table(s)
 */

namespace DreamSites\Blog\Setup;

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

        /**
         * Create table 'dreamsites_blog'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('dreamsites_blog')
        )->addColumn(
            'page_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
            'Page ID'
        )->addColumn(
            'title',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Page Title'
        )->addColumn(
            'content',
            Table::TYPE_TEXT,
            '64k',
            ['nullable' => false],
            'Body Content'
        )->addColumn(
            'permalink',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Permalink'
        )->addColumn(
            'image_filename',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Image Filename'
        )->addColumn(
            'image_alt',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Image Alt Text'
        )->addColumn(
            'has_comments',
            Table::TYPE_SMALLINT,
            1,
            ['nullable' => false, 'unsigned' => true, 'default' => '1'],
            'Has Comments Enabled'
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
            'Blog Table'
        );
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'dreamsites_blog_comment'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('dreamsites_blog_comment')
        )->addColumn(
            'comment_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
            'Comment ID'
        )->addColumn(
            'page_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'unsigned' => true],
            'Page ID'
        )->addIndex(
            $installer->getIdxName('dreamsites_blog_comment', ['page_id']),
            ['page_id']
        )->addForeignKey(
            $installer->getFkName(
                'dreamsites_blog_comment',
                'page_id',
                'dreamsites_blog',
                'page_id'
            ),
            'page_id',
            $installer->getTable('dreamsites_blog'),
            'page_id',
            Table::ACTION_CASCADE
        )->addColumn(
            'author_name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Author Name'
        )->addColumn(
            'author_email',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Author Email'
        )->addColumn(
            'content',
            Table::TYPE_TEXT,
            '64k',
            ['nullable' => false],
            'Comment Content'
        )->addColumn(
            'is_approved',
            Table::TYPE_SMALLINT,
            1,
            ['nullable' => false, 'unsigned' => true, 'default' => '0'], //this prevents spammers
            'Is Approved'
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
            'Blog Comments Table'
        );

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
