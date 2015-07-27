<?php

namespace OriginalAppName\Site\Elttl\Model\Tennis;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Encounter extends \OriginalAppName\Site\Elttl\Model\Tennis
{
   


    public $tableName = 'tennisEncounter';


    public $entity = '\\OriginalAppName\\Site\\Elttl\\Entity\\Tennis\\Encounter';


    public $fields = [
        'id',
        'yearId',
        'fixtureId',
        'playerIdLeft',
        'playerIdRight',
        'scoreLeft',
        'scoreRight',
        'playerRankChangeLeft',
        'playerRankChangeRight',
        'status'
    ];


    /**
     * filters away any passed statuses
     * @param  array $status e.g. exclude, doubles
     * @return object
     */
    public function filterStatus($status)
    {
        $molds = $this->getData();
        foreach ($molds as $key => $mold) {
            if (in_array($mold->status, $status)) {
                unset($molds[$key]);
            }
        }
        $this->setData($molds);
        return $this;
    }
}
