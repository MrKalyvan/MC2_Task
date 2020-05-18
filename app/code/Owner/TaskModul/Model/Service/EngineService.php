<?php

namespace Owner\TaskModul\Model\Service;

use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResultsInterface;
use Owner\TaskModul\Api\Data\EngineInterface;
use Owner\TaskModul\Api\RepositoryInterface\EngineRepositoryInterface;
use Owner\TaskModul\Api\ServiceInterface\EngineServiceInterface;

/**
 * Class EngineService
 * @package Owner\TaskModul\Model\Service
 */
class EngineService implements EngineServiceInterface
{
    /**
     * @var EngineRepositoryInterface
     */
    private $engineRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param EngineRepositoryInterface $engineRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        EngineRepositoryInterface $engineRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->engineRepository = $engineRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheritdoc
     */
    public function getEngineList()
    {
        /** @var SearchCriteria $searchCriteria */
        $searchCriteria = $this->searchCriteriaBuilder->create();
        /** @var SearchResultsInterface $searchResult */
        $searchResult = $this->engineRepository->getList($searchCriteria);
        $result = [];
        if($searchResult->getTotalCount() > 0) {
            foreach ($searchResult->getItems() as $item) {
                /** @var EngineInterface $item */
                $result[] = [
                    'entity_id' => $item->getId(),
                    'manufacturer' => $item->getManufacturer(),
                    'win' => $item->getWin(),
                    'power' => $item->getPower(),
                    'volume' => $item->getVolume(),
                    'years' => $item->getYears(),
                    'created_at' => $item->getCreatedAt()
                ];
            }
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getEngineById(int $engineId)
    {
        $result = [];
        if (empty($engineId)) {
            return 'empty param';
        }
        try {
            /** @var EngineInterface $item */
            $item = $this->engineRepository->getById($engineId);
            if ($item->getId()) {
                $result[] = [
                    'entity_id' => $item->getId(),
                    'manufacturer' => $item->getManufacturer(),
                    'win' => $item->getWin(),
                    'power' => $item->getPower(),
                    'volume' => $item->getVolume(),
                    'years' => $item->getYears(),
                    'created_at' => $item->getCreatedAt()
                ];
            }
        } catch (\Exception $exception) {

        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function deleteEngineById(int $engineId)
    {
        try {
            $this->engineRepository->deleteById($engineId);
            $message = sprintf('Engine (%s) has been deleted!', $engineId);
        } catch (\Exception $exception) {
            $message = sprintf('Could not delete engine (%s)', $engineId);
        }
        return $message;
    }

}