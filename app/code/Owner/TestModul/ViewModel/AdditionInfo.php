<?php


namespace Owner\TestModul\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class AdditionInfo
 * @package Owner\TestModul\ViewModel
 */
class AdditionInfo implements ArgumentInterface
{
    const USE_NEW_FIELD = 'owner_test/settings/use_new_field';
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
     * @return string
     * @throws \Exception
     */
    public function getData(){
        try{
            $date = new \DateTime('now');
            return $date->format('d:M:yy');
        } catch (\Exception $ex){
            return $ex;
        }
    }

    /**
     * @return mixed|string
     */
    public function useNewField(){
        $result = 'empty';
        try {
            $result = $this->scopeConf->getValue(self::USE_NEW_FIELD, self::SCOPE_TYPE);
        } catch (\Exception $ex) {}
        return $result;
    }
}