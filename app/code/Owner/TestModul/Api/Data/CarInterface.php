<?php

namespace Owner\TestModul\Api\Data;

//use Magento\Tests\NamingConvention\true\string;

/**
 * Interface CarInterface
 */
interface CarInterface
{
    const ENTITY_ID = 'entity_id';
    const NAME = 'name';
    const DESCRIPTION = 'description';
    const PRICE = 'price';
    const USER_ID = 'user_id';
    const CREATED_AT = 'created_at';

    /**
     * Get entity id
     *
     * @return int
     */
    public function getId();

    /**
     * Get car user id
     *
     * @return int
     */
    public function getUserId();

    /**
     * Get car name
     *
     * @return string
     */
    public function getName();

    /**
     * Get car description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get created at date
     *
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * Get car price
     *
     * @return float
     */
    public function getPrice();

    /**
     * Set entity id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Set user id
     *
     * @param int $userId
     * @return CarInterface
     */
    public function setUserId(int $userId): CarInterface;

    /**
     * Set car name
     *
     * @param string $name
     * @return CarInterface
     */
    public function setName(string $name): CarInterface;

    /**
     * Set car description
     *
     * @param string $description
     * @return CarInterface
     */
    public function setDescription(string $description): CarInterface;

    /**
     * Set created at date
     *
     * @param string $createdAt
     * @return CarInterface
     */
    public function setCreatedAt(string $createdAt): CarInterface;

    /**
     * Set car price
     *
     * @param float $price
     * @return CarInterface
     */
    public function setPrice(float $price): CarInterface;
}
