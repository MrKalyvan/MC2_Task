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


use Owner\TestModul\Model\CarModel;
use Owner\TestModul\Api\Data\CarInterface;
use Owner\TestModul\Model\ResourceModel\Car\Collection as CarCollection;
use Owner\TestModul\Model\ResourceModel\Car\CollectionFactory as CarCollectionFactory;
use Owner\TestModul\Api\CarRepositoryInterface;

/**
 * Class Cars
 * @package Owner\TestModul\Block
 */
class Cars extends Template
{
    /**
     * @var CarCollectionFactory
     */
    private $carCollection;

    /**
     * @var CarCollection|null
     */
    private $cars;

    /**
     * @var CarRepositoryInterface
     */
    private $carRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * Cars constructor.
     * @param Context $context
     * @param CarCollectionFactory $carCollection
     * @param CarRepositoryInterface $carRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        CarCollectionFactory $carCollection,
        CarRepositoryInterface $carRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->carCollection = $carCollection;
        $this->carRepository = $carRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;

    }

    /**
     * @return Template
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        if($this->cars === null) {
            $request = $this->getRequest();
            $userId = (int)$request->getParam(CarModel::USER_ID);

            /** @var SortOrder $sortOrder */
            $sortOrder = $this->sortOrderBuilder
                ->setField(CarInterface::CREATED_AT)
                ->setDirection(SortOrder::SORT_DESC)
                ->create();

            /** @var SearchCriteria|SearchCriteriaInterface $searchCriteria */
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter(
                    CarModel::USER_ID,
                    $userId,
                    'eq'
                )
                ->addSortOrder($sortOrder)
                ->create();

            /** @var SearchResult $searchResults */
            $searchResults = $this->cars = $this->carRepository->getList($searchCriteria);

            if ($searchResults->getTotalCount() > 0) {
                $this->cars = $searchResults->getItems();
            }
        }

        return parent::_prepareLayout();
    }

    /**
     * @return CarCollection|null
     */
    public function getCars(){
        return $this->cars;
    }
}