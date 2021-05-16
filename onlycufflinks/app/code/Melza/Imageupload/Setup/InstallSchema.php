<?php
namespace Melza\Imageupload\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
class InstallSchema implements InstallSchemaInterface
{
public function install(SchemaSetupInterface $setup,
ModuleContextInterface $context)
{
$installer = $setup;
$installer->startSetup();
/**
* Create table 'melza_imageupload'
*/
$table = $installer->getConnection()->newTable(
$installer->getTable('melza_imageupload')
)->addColumn(
'image_id',
\Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
null,
['identity' => true, 'nullable' => false, 'primary'
=> true],
'Image ID'
)->addColumn(
'filename',
\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
null,
[],
'Image Filename'
)->addColumn(
'store_id',
\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
null,
['nullable' => false],
'Store IDs Comma Separated, 0=All stores'
)->addColumn(
'url',
\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
255,
['nullable' => true],
'URL'
)->addColumn(
'title',
\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
255,
['nullable' => true],
'Image Title'
)->addColumn(
'image_identifier',
\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
255,
['nullable' => false],
'Image Identifier'
)->addColumn(
'creation_time',
\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
null,
[],
'Creation Time'
)->addColumn(
'update_time',
\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
null,
[],
'Modification Time'
)->addColumn(
'is_active',
\Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
null,
['nullable' => false, 'default' => '1'],
'Is Active'
)->addIndex(
$setup->getIdxName(
$installer->getTable('melza_imageupload'),
['title'],
AdapterInterface::INDEX_TYPE_FULLTEXT
),
['title'],
['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
)->setComment(
'Home Page Image Upload Table'
);
$installer->getConnection()->createTable($table);
$installer->endSetup();
}
}	