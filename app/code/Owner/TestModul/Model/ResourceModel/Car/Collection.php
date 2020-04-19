<?php


namespace Owner\TestModul\Model\ResourceModel\Car;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Owner\TestModul\Model\CarModel;
use Owner\TestModul\Model\ResourceModel\CarResource;

class Collection extends AbstractCollection
{
    /**
     * {@inheritDoc}
     */
    protected $_idFieldName = CarModel::ENTITY_ID;

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(
            CarModel::class,
            CarResource::class
        );
    }

}