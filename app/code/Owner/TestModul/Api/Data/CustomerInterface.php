<?php

namespace Owner\TestModul\Api\Data;

/**
 * Interface CarCustomerInterface
 * @package Owner\TestModul\Api\Data
 */
interface CustomerInterface
{
    const ENTITY_ID = 'entity_id';

    const EMAIL = 'email';

    const NAME = 'name';

    const CREATED_AT = 'created_at';

    /**
     * Get entity id
     *
     * @return int
     */
    public function getId();

    /**
     * Get customer email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Get customer name
     *
     * @return string
     */
    public function getName();

    /**
     * Get created at date
     *
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * Set entity id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Set customer email
     *
     * @param string $email
     * @return CustomerInterface
     */
    public function setEmail(string $email): CustomerInterface;

    /**
     * Set customer name
     *
     * @param string $name
     * @return CustomerInterface
     */
    public function setName(string $name): CustomerInterface;

    /**
     * Set created at date
     *
     * @param string $createdAt
     * @return CustomerInterface
     */
    public function setCreatedAt(string $createdAt): CustomerInterface;
}
