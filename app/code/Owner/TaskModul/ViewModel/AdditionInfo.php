<?php

namespace Owner\TaskModul\ViewModel;

use Owner\TaskModul\Api\Data\CarInterface;
use Owner\TaskModul\Api\Data\EngineInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class AdditionInfo
 * @package Owner\TestModul\ViewModel
 */
class AdditionInfo implements ArgumentInterface
{
    const USE_SORT = 'owner_task/settings/use_sort';

    const USE_NUMBER_RECORDS = 'owner_task/settings/number_records';

    const USE_ADMIN_SORT_SETTING = 'owner_task/settings/use_admin_setting';

    const SCOPE_TYPE = 'store';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConf;

    /**
     * @param ScopeConfigInterface $scopeConf
     */
    public function __construct(
        ScopeConfigInterface $scopeConf
    ) {
        $this->scopeConf = $scopeConf;
    }

    /**
     * @return string[]
     */
    public function getCarColumn()
    {
        $masCar = array(
            CarInterface::BRAND => 'Brand',
            CarInterface::MODEL => 'Model',
            CarInterface::PRICE => 'Price',
            CarInterface::CREATED_AT => 'Created at'
        );
        return $masCar;
    }

    /**
     * @return string[]
     */
    public function getEngineColumn()
    {
        $masEngine = array(
            EngineInterface::MANUFACTURER => 'Manufacturer',
            EngineInterface::WIN => 'Win',
            EngineInterface::POWER => 'Power',
            EngineInterface::VOLUME => 'Volume',
            EngineInterface::CREATED_AT => 'Created at'
        );
        return $masEngine;
    }

    /**
     * Use or not sort setting from admin panel
     *
     * @return int
     */
    public function getAdminSetting()
    {
        $result = 0;
        try {
            $result = (int)$this->scopeConf->getValue(self::USE_ADMIN_SORT_SETTING, self::SCOPE_TYPE);
        } catch (\Exception $exception) {

        }
        return $result;
    }

    /**
     * Count of displayed item
     *
     * @return int
     */
    public function getNumberRecord()
    {
        $result = 0;
        try {
            $result = (int)$this->scopeConf->getValue(self::USE_NUMBER_RECORDS, self::SCOPE_TYPE);
        } catch (\Exception $ex) {

        }
        return $result;
    }

    /**
     * True - use sort ASC. False - use sort DESC
     *
     * @return string
     */
    public function useSort()
    {
        $result = 'ASC';
        try {
            $result = $this->scopeConf->getValue(self::USE_SORT, self::SCOPE_TYPE);
        } catch (\Exception $ex) {}
        return $result;
    }
}