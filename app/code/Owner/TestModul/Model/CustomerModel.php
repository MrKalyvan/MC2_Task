<?php

namespace Owner\TestModul\Model;

use Magento\Framework\Model\AbstractModel;
//use Magento\Tests\NamingConvention\true\string;
use Owner\TestModul\Api\Data\CustomerInterface;
use Owner\TestModul\Model\ResourceModel\CustomerResource;

class CustomerModel extends AbstractModel implements CustomerInterface
{

    /**
     * {@inheritDoc}
     */
    public function _construct()
    {
        $this->_init(CustomerResource::class );
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }


    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function setEmail(string $email) :CustomerInterface
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * {@inheritDoc}
     */
    public function setName(string $name) :CustomerInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedAt(string $created_At) :CustomerInterface
    {
        $createdAtObject = new \DateTime($created_At);
        return $this->setData(self::CREATED_AT, $createdAtObject->format('Y-m-d H:i:s'));
    }


}