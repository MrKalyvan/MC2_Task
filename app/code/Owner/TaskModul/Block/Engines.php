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
use Owner\TaskModul\Model\ResourceModel\Engine\Collection;
use Owner\TaskModul\Model\ResourceModel\Engine\CollectionFactory;
use Owner\TaskModul\Api\RepositoryInterface\EngineRepositoryInterface;
use Owner\TaskModul\ViewModel\AdditionInfo;

/**
 * Class Engines
 * @package Owner\TaskModul\Block
 */
class Engines extends Template
{
    /**
     * @var CollectionFactory
     */
    private $engineCollectionFactory;

    /**
     * @var Collection|null
     */
    private $engines;

    /**
     * @var EngineRepositoryInterface
     */
    private $engineRepository;

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
     * Engines constructor.
     * @param Context $context
     * @param CollectionFactory $engineCollectionFactory
     * @param EngineRepositoryInterface $engineRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param AdditionInfo $additionInfo
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $engineCollectionFactory,
        EngineRepositoryInterface $engineRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        AdditionInfo $additionInfo,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->engineCollectionFactory = $engineCollectionFactory;
        $this->engineRepository = $engineRepository;
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
        if($this->engines === null){

            $sort_type = $this->additionInfo->useSort();

            /** @var SortOrder $sortOrder */
            $sortOrder = $this->sortOrderBuilder
                ->setField(CarInterface::CREATED_AT)
                ->setDirection($sort_type)
                ->create();

            /** @var SearchCriteria|SearchCriteriaInterface $searchCriteria */
            $searchCriteria = $this->searchCriteriaBuilder
                ->addSortOrder($sortOrder)
                ->create();

            /** @var SearchResult $searchResults */
            $searchResults = $this->engines = $this->engineRepository->getList($searchCriteria);

            if($searchResults->getTotalCount() > 0){
                $this->engines = $searchResults->getItems();
            }
        }

        return parent::_prepareLayout();
    }

    /**
     * @return Collection|null
     */
    public function getEngines(){
        return $this->engines;
    }
}