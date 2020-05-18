<?php

namespace Owner\TaskModul\Api\ServiceInterface;

use Owner\TaskModul\Api\Data\EngineInterface;

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

    /**
     * @param EngineInterface $engine
     * @return mixed
     */
    public function saveOrUpdate(EngineInterface $engine);
}
