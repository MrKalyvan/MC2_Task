<?php

namespace Owner\TestModul\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

/**
 * Class UpgradeSchema
 * @package Owner\TestModul\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        // beware, this is the version we are upgrading from, not to!
        $moduleVersion = $context->getVersion();
        if (version_compare($moduleVersion, '0.0.3', '<')) {
            $this->updateMyTable($setup);
        }
    }

    /**
     * @param SchemaSetupInterface $setup
     */
    private function updateMyTable($setup)
    {
        $setup->startSetup();

        $tableName = $setup->getTable('testTable_oldWay');
        $setup->getConnection()->modifyColumn(
                $tableName,
                'some_id',
                [
                    'type' => Table::TYPE_INTEGER,
                    'size' => 11
                ]
            )
            ->addColumn(
            $tableName,
            'name',
            [
                'type' => Table::TYPE_TEXT,
                'length' => 128,
                'nullable' => true,
                'comment' => 'Name'
            ]
        );

        $setup->endSetup();
    }
}
