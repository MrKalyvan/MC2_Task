<?php


namespace Owner\TestModul\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Owner\TestModul\Model\CarModel;


/**
 * Class CarResource
 * @package Owner\TestModul\Model\ResourceModel
 */
class CarResource extends AbstractDb
{
    const CAR_TABLE = 'car_NewTable';

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(
            self::CAR_TABLE,
            CarModel::ENTITY_ID
        );
    }
}