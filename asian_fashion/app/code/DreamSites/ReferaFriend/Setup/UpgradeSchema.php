<?php
namespace DreamSites\ReferaFriend\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
	{

	if (version_compare($context->getVersion(), '1.0.4', '<'))
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
			'primary'	=> true
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
		//		$installer->getConnection()->dropTable($installer->getTable('dreamsites_referafriend'));
				$installer->getConnection()->createTable($table);
				$installer->endSetup();
		}

		if (version_compare($context->getVersion(), '1.0.4', '<'))
		{
			$installer = $setup;
			$installer->startSetup();

			$installer->getConnection()
			->dropColumn(
				$installer->getTable( 'dreamsites_referafriend' ),
				'creation_time'
			);

			$installer->getConnection()
			->dropColumn(
				$installer->getTable( 'dreamsites_referafriend' ),
				'update_time'
			);

			$installer->getConnection()
			->addColumn(
				$installer->getTable( 'dreamsites_referafriend' ),
				'created_at',
				Table::TYPE_TIMESTAMP,
				null,
				['nullable' => false],
				'Created At'
			);

			$installer->getConnection()
			->addColumn(
				$installer->getTable( 'dreamsites_referafriend' ),
				'updated_at',
				Table::TYPE_TIMESTAMP,
				null,
				['nullable' => true],
				'Updated At'
			);

			$installer->getConnection()
			->addColumn(
				$installer->getTable( 'dreamsites_referafriend' ),
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
				$installer->getTable( 'dreamsites_referafriend' ),
				'discount_amount',
				Table::TYPE_DECIMAL,
				null,
				['nullable' => false, 'length' => '12,4'],
				'Discount Amount'
			);

			$installer->getConnection()
			->addColumn(
				$installer->getTable( 'dreamsites_referafriend' ),
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