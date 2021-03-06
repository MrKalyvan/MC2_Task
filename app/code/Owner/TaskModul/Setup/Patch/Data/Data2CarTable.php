<?php

namespace Owner\TaskModul\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Psr\Log\LoggerInterface;

/**
 * Class DataCarTable
 * @package Owner\TaskModul\Setup\Patch\Data
 */
class Data2CarTable implements DataPatchInterface
{
    const MODEL_CAR = 'model_car';

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param LoggerInterface $logger
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        LoggerInterface $logger
    ) {
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
                'brand' => 'Mercedes-Benz',
                'model' => 'E200',
                'engine_id' => 4,
                'price' => 8000,
                'years' => '2003–2006',
            ],
            [
                'entity_id' => null,
                'brand' => 'Mercedes-Benz',
                'model' => 'E240',
                'engine_id' => 2,
                'price' => 10000,
                'years' => '2003–2006',
            ],
            [
                'entity_id' => null,
                'brand' => 'Mercedes-Benz',
                'model' => 'E200',
                'engine_id' => 1,
                'price' => 7000,
                'years' => '2003–2006',
            ],
            [
                'entity_id' => null,
                'brand' => 'BMW',
                'model' => 'M750',
                'engine_id' => 7,
                'price' => 15000,
                'years' => '1994-2001',
            ],
            [
                'entity_id' => null,
                'brand' => 'BMW',
                'model' => 'M740',
                'engine_id' => 6,
                'price' => 13000,
                'years' => '1994-2001',
            ]
        ];

        try {
            $connection = $this->moduleDataSetup->getConnection();
            foreach ($data as $row) {
                $connection->insert(self::MODEL_CAR, $row);
            }
        }
        catch (\Exception $exception){
            $this->logger->debug('Problem with insert date.' . $exception->getMessage() );
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
