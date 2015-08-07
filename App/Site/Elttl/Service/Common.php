<?php

namespace OriginalAppName\Site\Elttl\Service;

/**
 * services group up controller commands
 * making the controllers more readable and tidy
 */
class Common extends \OriginalAppName\Service
{


    public function read()
    {
        
        // menu primary
        $json = new \OriginalAppName\Json;
        $json->read('menu-primary');
        $menuPrimary = $json->getData();

        // menu Secondary
        $json = new \OriginalAppName\Json;
        $json->read('menu-secondary');
        $menuSecondary = $json->getData();

        // menu Tertiary
        $json = new \OriginalAppName\Json;
        $json->read('menu-tertiary');
        $menuTertiary = $json->getData();

        // divisions
        $modelTennisDivision = new \OriginalAppName\Site\Elttl\Model\Tennis\Division;
        $registry = \OriginalAppName\Registry::getInstance();
        $modelTennisDivision->readColumn('yearId', $registry->get('database/options/yearId'));

        // 
        $year = $this->getYear();

        // template
        return [
            'socials' => [
                'twitter' => 'https://twitter.com/eastlancstt',
                'facebook' => 'https://www.facebook.com/pages/East-Lancashire-Table-Tennis-League/118206128284149'
            ],
            'googleAnalyticsTrackingId' => 'UA-35261063-1',
            'divisions' => $modelTennisDivision->getData(),
            'menuPrimary' => $menuPrimary,
            'menuSecondary' => $menuSecondary,
            'campaign' => new \OriginalAppName\Google\Analytics\Campaign,
            'year' => $year,
            'years' => $this->getYears($year),
            'menuTertiary' => $menuTertiary
        ];
    }


    public function getYear()
    {
        $registry = \OriginalAppName\Registry::getInstance();
        $modelYear = new \OriginalAppName\Site\Elttl\Model\Tennis\Year;
        $modelYear->readId([$registry->get('database/options/yearId')]);
        return $modelYear->getDataFirst();
    }


    public function getYears()
    {
        $modelYear = new \OriginalAppName\Site\Elttl\Model\Tennis\Year;
        $modelYear->read();
        return $modelYear->getData();
    }
}
