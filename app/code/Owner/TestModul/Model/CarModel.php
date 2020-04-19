<?php

namespace Owner\TestModul\Model;

use Magento\Framework\Model\AbstractModel;
use Owner\TestModul\Api\Data\CarInterface;
use Owner\TestModul\Model\ResourceModel\CarResource;

/**
 * Class CarModel
 * @package Owner\TestModul\Model
 */
class CarModel extends AbstractModel implements CarInterface
{

    /**
     * {@inheritDoc}
     */
    public function _construct()
    {
        $this->_init(CarResource::class);
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
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * {@inheritDoc}
     */

    public function getPrice()
    {
        return $this->getData(self::PRICE);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserId()
    {
        return $this->getData(self::USER_ID);
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
    public function setName(string $name) :CarInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * {@inheritDoc}
     */
    public function setDescription(string $desc) :CarInterface
    {
        return $this->setData(self::DESCRIPTION, $desc);
    }

    /**
     * {@inheritDoc}
     */
    public function setPrice(float $price) :CarInterface
    {
        return $this->setData(self::PRICE, $price);
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedAt(string $created_At) :CarInterface
    {
        $createdAtObject = new \DateTime($created_At);
        return $this->setData(self::CREATED_AT, $createdAtObject->format('Y-m-d H:i:s'));
    }

    /**
     * {@inheritDoc}
     */
    public function setUserId(int $id) :CarInterface
    {
        return $this->setData(self::USER_ID, $id);
    }
}