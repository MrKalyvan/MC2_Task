<?php

namespace Owner\TestModul\Model;

use Magento\Framework\Api\SearchResults;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

use Owner\TestModul\Api\CarRepositoryInterface;
use Owner\TestModul\Api\Data\CarInterface;
use Owner\TestModul\Model\CarModelFactory;
use Owner\TestModul\Model\ResourceModel\Car\Collection;
use Owner\TestModul\Model\ResourceModel\Car\CollectionFactory;
use Owner\TestModul\Model\ResourceModel\CarResource;

/**
 * Class CarRepository
 * @package Owner\TestModul\Model
 */
class CarRepository implements CarRepositoryInterface
{
    /**
     * @var CarModelFactory
     */
    private $carFactory;

    /**
     * @var CollectionFactory
     */
    private $carCollectionFactory;

    /**
     * @var CarResource
     */
    private $carResource;

    /**
     * @type SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @type CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param CarModelFactory $carFactory
     * @param CollectionFactory $carCollectionFactory
     * @param CarResource $carResource
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        CarModelFactory $carFactory,
        CollectionFactory $carCollectionFactory,
        CarResource $carResource,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->carFactory = $carFactory;
        $this->carCollectionFactory = $carCollectionFactory;
        $this->carResource = $carResource;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function save(CarInterface $car): CarInterface
    {
        try {
            /** @var CarModel|CarInterface $car */
            $this->carResource->save($car);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $car;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $carId): CarInterface
    {
        /** @var CarModel|CarInterface $car */
        $car = $this->carFactory->create();
        $car->load($carId);
        if (!$car->getId()) {
            throw new NoSuchEntityException(__('Car Customer entity with id `%1` does not exist.', $carId));
        }

        return $car;
    }

    /**
     * {@inheritDoc}
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResults
    {
        /** @var Collection $collection */
        $collection = $this->carCollectionFactory->create();
        $this->collectionProcessor->process($criteria, $collection);

        /** @var SearchResults $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(CarInterface $car): bool
    {
        try {
            /** @var CarModel $car */
            $this->carResource->delete($car);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById(int $carId): bool
    {
        return $this->delete($this->getById($carId));
    }
}
