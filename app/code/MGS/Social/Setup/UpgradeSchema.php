<?php
/**
* Copyright © 2016 MGS-THEMES. All rights reserved.
*/

namespace MGS\Social\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (version_compare($context->getVersion(), '2.0.1', '<=')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('mgs_instagram_cache')
            )->addColumn(
                'cache_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Cache ID'
            )->addColumn(
                'instagram_data',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '10M',
                ['unsigned' => true],
                'Instagram Data'
            )->addColumn(
                'creation_time',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Instagram Creation Time'
            )->setComment(
                'Instagram Log'
            );
            $installer->getConnection()->createTable($table);
        }
		
		if (version_compare($context->getVersion(), '2.0.2', '<=')) {
			$tableCache = $installer->getTable('mgs_instagram_cache');
			
            if ($installer->getConnection()->isTableExists($tableCache) == true) {
				$installer->getConnection()->addColumn($tableCache, 'store_id', [
					'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					'nullable' => true,
					'after' => 'cache_id',
					'comment' => 'Store Id'
				]);
			}
		}
        $installer->endSetup();
    }
}