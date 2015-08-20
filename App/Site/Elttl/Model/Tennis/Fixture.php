<?php

namespace OriginalAppName\Site\Elttl\Model\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Fixture extends \OriginalAppName\Site\Elttl\Model\Tennis
{
   


    public $tableName = 'tennisFixture';


    public $entity = '\\OriginalAppName\\Site\\Elttl\\Entity\\Tennis\\Fixture';


    public $fields = array(
        'id',
        'yearId',
        'teamIdLeft',
        'teamIdRight',
        'timeFulfilled'
    );


    /**
     * structure representing the player positioning for a standard
     * table tennis league match
     * @var array
     */
    public $encounterStructure = [
        [1, 2],
        [3, 1],
        [2, 3],
        [3, 2],
        [1, 3],
        ['doubles', 'doubles'],
        [2, 1],
        [3, 3],
        [2, 2],
        [1, 1]
    ];


    /**
     * @return array
     */
    public function getEncounterStructure()
    {
        return $this->encounterStructure;
    }
    
    
    /**
     * @param array $encounterStructure
     */
    public function setEncounterStructure($encounterStructure)
    {
        $this->encounterStructure = $encounterStructure;
        return $this;
    }


    public function orderByHighestPoints()
    {
        $data = $this->getData();
        uasort($data, function ($a, $b) {
            if ($a->points == $b->points) {
                return 0;
            }
            return $a->points > $b->points ? -1 : 1;
        });
        $this->setData($data);
        return $this;
    }
}
