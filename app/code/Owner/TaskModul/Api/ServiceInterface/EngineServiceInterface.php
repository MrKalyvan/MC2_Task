<?php

namespace Owner\TaskModul\Api\ServiceInterface;

/**
 * Interface CarServiceInterface
 * @package Owner\TaskModul\Api\ServiceInterface
 */
interface EngineServiceInterface
{
    /**
     * @return mixed
     */
    public function getEngineList();

    /**
     * @param int $engineId
     * @return mixed
     */
    public function getEngineById(int $engineId);

    /**
     * @param int $engineId
     * @return mixed
     */
    public function deleteEngineById(int $engineId);
}
