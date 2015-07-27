<?php

namespace OriginalAppName\Site\Elttl\Entity\Tennis;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Team extends \OriginalAppName\Entity
{

    
    public $id;


    public $yearId;

    
    public $name;


    public $slug;

    
    public $homeWeekday;

    
    public $secretaryId;


    public $venueId;


    public $divisionId;


    public $weekdays;


    /**
     * @return array
     */
    public function getWeekdays()
    {
        return array(
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday'
        );
    }


    /**
     * weekday as string
     * @return string
     */
    public function getHomeWeekdayName()
    {
        $weekdays = $this->getWeekdays();
        $key = $this->homeWeekday;
        if (\OriginalAppName\Helper::arrayKeyExists([$key], $weekdays)) {
            return $weekdays[$key];
        }
    }
}
