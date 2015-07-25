<?php

namespace OriginalAppName\Site\Elttl\Service\Tennis;

/**
 * services group up controller commands
 * making the controllers more readable and tidy
 */
class Year extends \OriginalAppName\Service
{


    public function readId($id)
    {
        $modelYear = new \OriginalAppName\Site\Elttl\Model\Tennis\Year;
        $modelYear->readId([$id]);
        return current($modelYear->getData());
    }


    public function readName($name)
    {
        $modelYear = new \OriginalAppName\Site\Elttl\Model\Tennis\Year;
        $modelYear->readColumn('name', $name);
        return current($modelYear->getData());
    }


    public function read()
    {
        $modelYear = new \OriginalAppName\Site\Elttl\Model\Tennis\Year;
        return $modelYear
            ->read()
            ->orderByProperty('name', 'desc')
            ->getData();
    }
}
