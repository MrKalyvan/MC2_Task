<?php


namespace Owner\TestModul\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Owner\TestModul\Model\CustomerModel;


/**
 * Class CustomerResource
 * @package Owner\TestModul\Model\ResourceModel
 */
class CustomerResource extends AbstractDb
{
    const CUSTOMER_TABLE = 'customer_NewTable';

    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(
            self::CUSTOMER_TABLE,
            CustomerModel::ENTITY_ID
        );
    }
}