<?php


namespace Owner\TestModul\Block;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Api\Search\SearchResult;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

use Owner\TestModul\Api\Data\CustomerInterface;
use Owner\TestModul\Model\CustomerModel;
use Owner\TestModul\Model\ResourceModel\Customer\Collection as CustomerCollection;
use Owner\TestModul\Model\ResourceModel\Customer\CollectionFactory as CustomerCollectionFactory;
use Owner\TestModul\Api\CustomerRepositoryInterface;


/**
 * Class Customers
 * @package Owner\TestModul\Block
 */

class Customers extends Template
{
    /**
     * @var CustomerCollectionFactory
     */
    private $customerCollection;

    /**
     * @var CustomerCollection|null
     */
    private $customers;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * Customers constructor.
     * @param Context $context
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param CustomerCollectionFactory $customerCollection
     * @param CustomerRepositoryInterface $customerRepository
     * @param SortOrderBuilder $sortOrderBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        CustomerCollectionFactory $customerCollection,
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->customerCollection = $customerCollection;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->customerRepository = $customerRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @return Template
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
//        if($this->customers === null){
//            $this->customers = $this->customerCollection->create();
//            $this->customers->setOrder(CustomerModel::CREATED_AT, 'ASC');
//        }

        if($this->customers === null){

            /** @var SortOrder $sortOrder */
            $sortOrder = $this->sortOrderBuilder
                ->setField(CustomerInterface::CREATED_AT)
                ->setDirection(SortOrder::SORT_DESC)
                ->create();

            /** @var SearchCriteria|SearchCriteriaInterface $searchCriteria */
            $searchCriteria = $this->searchCriteriaBuilder
                ->addSortOrder($sortOrder)
                ->create();

            /** @var SearchResult $searchResults */
            $searchResults = $this->customers = $this->customerRepository->getList($searchCriteria);

            if($searchResults->getTotalCount() > 0){
                $this->customers = $searchResults->getItems();
            }
        }

        return parent::_prepareLayout();
    }

    /**
     * @return CustomerCollection|null
     */
    public function getCustomers(){
        return $this->customers;
    }
}