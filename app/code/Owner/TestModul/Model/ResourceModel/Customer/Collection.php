<?php


namespace Owner\TestModul\Model\ResourceModel\Customer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Owner\TestModul\Model\CustomerModel;
use Owner\TestModul\Model\ResourceModel\CustomerResource;

class Collection extends AbstractCollection
{
    /**
     * {@inheritDoc}
     */
    protected $_idFieldName = CustomerModel::ENTITY_ID;

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(
            CustomerModel::class,
            CustomerResource::class
        );
    }

}