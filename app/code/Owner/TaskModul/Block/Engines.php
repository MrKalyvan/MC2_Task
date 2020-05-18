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
    const SORT_FIELD_DEFAULT = 'created_at';

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
    ) {
        parent::__construct($context, $data);
        $this->engineCollectionFactory = $engineCollectionFactory;
        $this->engineRepository = $engineRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->additionInfo = $additionInfo;
    }

    /**
     * @return bool|int|null
     */
    public function getCacheLifetime()
    {
        return null;
    }

    /**
     * @return Template
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        if ($this->engines === null) {

            if($this->additionInfo->getAdminSetting() === 0) {
                // Custom filter
                $request = $this->getRequest();
                $sortType = (string)$request->getParam('sortType');
                $sortField = (string)$request->getParam('sortField');

                /** @var SortOrder $sortOrder */
                $sortOrder = $this->sortOrderBuilder
                    ->setField($sortField)
                    ->setDirection($sortType)
                    ->create();
            }
            else {
                // Admin setting filter
                /** @var SortOrder $sortOrder */
                $sortOrder = $this->sortOrderBuilder
                    ->setField(self::SORT_FIELD_DEFAULT)
                    ->setDirection($this->additionInfo->useSort())
                    ->create();
            }

            /** @var SearchCriteria|SearchCriteriaInterface $searchCriteria */
            $searchCriteria = $this->searchCriteriaBuilder
                ->addSortOrder($sortOrder)
                ->create();

            /** @var SearchResult $searchResults */
            $searchResults = $this->engines = $this->engineRepository->getList($searchCriteria);

            if ($searchResults->getTotalCount() > 0) {
                $this->engines = $searchResults->getItems();
            }
        }

        return parent::_prepareLayout();
    }

    /**
     * Use custom filter on page
     *
     * @return string
     */
    public function useFilter()
    {
        $request = $this->getRequest();
        $sortType = (string)$request->getParam('sortType');
        $sortField = (string)$request->getParam('sortField');
        return $this->getUrl(
            'route_last',
            [
                '_current' => true,
                '_query' =>
                    [
                        'sortType' => $sortType,
                        'sortField' => $sortField
                    ]
            ]
        );
    }

    /**
     * @return Collection|null
     */
    public function getEngines()
    {
        return $this->engines;
    }

    /**
     * @param int $engineId
     * @return string
     */
    public function deleteById(int $engineId)
    {
        return $this->engineRepository->deleteById($engineId);
    }
}