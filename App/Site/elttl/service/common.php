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

        // template
        return [
            'googleAnalyticsTrackingId' => 'UA-35261063-1',
            'divisions' => $modelTennisDivision->getData(),
            'menuPrimary' => $menuPrimary,
            'menuSecondary' => $menuSecondary,
            'campaign' => new \OriginalAppName\Google\Analytics\Campaign,
            'menuTertiary' => $menuTertiary
        ];
    }
}
