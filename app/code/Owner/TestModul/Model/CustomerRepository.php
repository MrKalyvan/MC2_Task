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

use Owner\TestModul\Api\CustomerRepositoryInterface;
use Owner\TestModul\Api\Data\CustomerInterface;
use Owner\TestModul\Model\CustomerModelFactory;
use Owner\TestModul\Model\ResourceModel\Customer\Collection;
use Owner\TestModul\Model\ResourceModel\Customer\CollectionFactory;
use Owner\TestModul\Model\ResourceModel\CustomerResource;

/**
 * Class CustomerRepository
 * @package Owner\TestModul\Model
 */
class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * @var CustomerModelFactory
     */
    private $customerFactory;

    /**
     * @var CollectionFactory
     */
    private $customerCollectionFactory;

    /**
     * @var CustomerResource
     */
    private $customerResource;

    /**
     * @type SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @type CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param CustomerModelFactory $customerFactory
     * @param CollectionFactory $customerCollectionFactory
     * @param CustomerResource $customerResource
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        CustomerModelFactory $customerFactory,
        CollectionFactory $customerCollectionFactory,
        CustomerResource $customerResource,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->customerFactory = $customerFactory;
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->customerResource = $customerResource;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function save(CustomerInterface $customer): CustomerInterface
    {
        try {
            /** @var CustomerModel|CustomerInterface $customer */
            $this->customerResource->save($customer);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $customer;
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $customerId): CustomerInterface
    {
        /** @var CustomerModel|CustomerInterface $customer */
        $customer = $this->customerFactory->create();
        $customer->load($customerId);
        if (!$customer->getId()) {
            throw new NoSuchEntityException(__('Car Customer entity with id `%1` does not exist.', $customerId));
        }

        return $customer;
    }

    /**
     * {@inheritDoc}
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResults
    {
        /** @var Collection $collection */
        $collection = $this->customerCollectionFactory->create();
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
    public function delete(CustomerInterface $customer): bool
    {
        try {
            /** @var CustomerModel $customer */
            $this->customerResource->delete($customer);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById(int $customerId): bool
    {
        return $this->delete($this->getById($customerId));
    }
}
