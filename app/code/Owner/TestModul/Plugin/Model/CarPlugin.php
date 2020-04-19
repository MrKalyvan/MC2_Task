<?php


namespace Owner\TestModul\Plugin\Model;

use Owner\TestModul\Api\Data\CarInterface;

class CarPlugin
{
    public function aroundGetDescription(CarInterface $subject){
        $description = '(This\'s arountGetDescription!) ';
        return $description;
    }

}