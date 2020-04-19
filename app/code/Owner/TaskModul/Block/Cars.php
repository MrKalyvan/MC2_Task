<?php


namespace Owner\TaskModul\Block;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Api\Search\SearchResult;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

use Owner\TaskModul\Api\Data\CarInterface;
use Owner\TaskModul\Model\CarModel;
use Owner\TaskModul\Model\EngineModel;
use Owner\TaskModul\Model\ResourceModel\Car\Collection;
use Owner\TaskModul\Model\ResourceModel\Car\CollectionFactory;
use Owner\TaskModul\Api\RepositoryInterface\CarRepositoryInterface;
use Owner\TaskModul\ViewModel\AdditionInfo;


/**
 * Class Cars
 * @package Owner\TaskModul\Block
 */
class Cars extends Template
{
    /**
     * @var CollectionFactory
     */
    private $carCollectionFactory;

    /**
     * @var Collection|null
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
     * @var AdditionInfo
     */
    private $additionInfo;


    /**
     * Cars constructor.
     * @param Context $context
     * @param CollectionFactory $carCollectionFactory
     * @param CarRepositoryInterface $carRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param AdditionInfo $additionInfo
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $carCollectionFactory,
        CarRepositoryInterface $carRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        AdditionInfo $additionInfo,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->carCollectionFactory = $carCollectionFactory;
        $this->carRepository = $carRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->additionInfo = $additionInfo;
    }

    /**
     * @return Template
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        if($this->cars === null){
            $request = $this->getRequest();
            $engineId = (int)$request->getParam(CarModel::ENGINE_ID);

            $sort_type = $this->additionInfo->useSort();

            /** @var SortOrder $sortOrder */
            $sortOrder = $this->sortOrderBuilder
                ->setField(CarInterface::CREATED_AT)
                ->setDirection($sort_type)
                ->create();

            /** @var SearchCriteria|SearchCriteriaInterface $searchCriteria */
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter(
                    CarModel::ENGINE_ID,
                    $engineId,
                    'eq'
                )
                ->addSortOrder($sortOrder)
                ->create();

            /** @var SearchResult $searchResults */
            $searchResults = $this->cars = $this->carRepository->getList($searchCriteria);

            if($searchResults->getTotalCount() > 0){
                $this->cars = $searchResults->getItems();
            }
        }

        return parent::_prepareLayout();
    }

    /**
     * @return Collection|null
     */
    public function getCars(){
        return $this->cars;
    }
}