<?php

namespace Owner\TestModul\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Tax\Api\TaxClassManagementInterface;

/**
 * Class InstallData
 * @package Owner\TestModul\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * {@inheritDoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        $tableName = $setup->getTable('customer_NewTable');
        $data = [
            [
                'entity_id' => null,
                'email' => 'user1@user1.com',
                'name' => 'user1',
            ],
            [
                'entity_id' => null,
                'email' => 'user2@user2.com',
                'name' => 'user2',
            ],
            [
                'entity_id' => null,
                'email' => 'newUser@newUser.com',
                'name' => 'newUser',
            ],
            [
                'entity_id' => null,
                'email' => 'roma@gmail.com',
                'name' => 'roma',
            ]
        ];
        $setup->getConnection()->insertMultiple($tableName, $data);
    }
}
