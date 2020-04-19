<?php

namespace Owner\TestModul\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

/**
 * Class UpgradeData
 * @package Owner\TestModul\Setup
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        // Used update query because all scopes needed to have this value updated and this is a fast, simple approach
        if (version_compare($context->getVersion(), '0.0.4', '<')) {
            $this->updateMyTableData($setup);
        }
    }

    /**
     * @param ModuleDataSetupInterface $setup
     */
    private function updateMyTableData($setup)
    {
        $tableName = $setup->getTable('testTable_oldWay');
        $data = [
            [
                'name' => 'User 1'
            ],
            [
                'name' => 'User 2'
            ],
            [
                'name' => 'User 3'
            ],
            [
                'name' => 'User 4'
            ],
            [
                'name' => 'User 5'
            ]
        ];

        for ($i = 0; $i < count($data); $i++) {
            $setup->getConnection()->update(
                $tableName,
                $data[$i],
                ['entity_id = ?' => $i + 1]
            );
        }
    }
}
