<?php


namespace Owner\TestModul\Setup\Patch\Data;

use Magento\Cms\Block\Block;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Setup\Exception;
use Psr\Log\LoggerInterface;

/**
 * Class DataIntoCarTable
 * @package Owner\TestModul\Setup\Patch\Data
 */
class DataCarTable implements DataPatchInterface
{
    const CAR_TABLE = 'car_NewTable';
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * DataCarTable constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param LoggerInterface $logger
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        LoggerInterface $logger
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $data = [
            [
                'entity_id' => null,
                'name' => 'Ford Mustang GT',
                'user_id' => 1,
                'description' =>'',
                'created_at' => ''
            ],
            [
                'entity_id' => null,
                'name' => 'Renault Logan',
                'user_id' => 1,
                'description' =>'',
                'created_at' => ''
            ],
            [
                'entity_id' => null,
                'name' => 'BMW X5',
                'user_id' => 2,
                'description' =>'',
                'created_at' => ''
            ],
            [
                'entity_id' => null,
                'name' => 'BMW X6',
                'user_id' => 5,
                'description' =>'',
                'created_at' => ''
            ]
        ];

        try {
            $connection = $this->moduleDataSetup->getConnection();
            $connection->truncateTable(self::CAR_TABLE);


            foreach ($data as $row) {
                $row['created_at'] = time();
                $connection->insert(self::CAR_TABLE, $row);
            }
        }
        catch (\Exception $exception){
            $this->logger->debug('Cannot insert row, message: "' . $exception->getMessage() . '"');
        }

        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
