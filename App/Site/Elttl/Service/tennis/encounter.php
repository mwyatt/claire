<?php

namespace OriginalAppName\Site\Elttl\Service\Tennis;

use OriginalAppName\Site\Elttl\Model;

/**
 * services group up controller commands
 * making the controllers more readable and tidy
 */
class Encounter extends \OriginalAppName\Service
{


    public function convertToFixtureResults()
    {
        if (! $molds = $this->getData()) {
            return;
        }
        $collection = array();
        foreach ($molds as $mold) {
            // create object entry for player if not exist
            $fixtureId = $mold->getFixtureId();
            if (! array_key_exists($fixtureId, $collection)) {
                $collection[$fixtureId] = (object) array(
                    'score_left' => 0,
                    'score_right' => 0
                );
            }

            // get scores
            $collection[$fixtureId]->score_left += $mold->getScoreLeft();
            $collection[$fixtureId]->score_right += $mold->getScoreRight();
        }

        // return [fixtureId], won, played, average objects
        $this->setData($collection);
        return $this;
    }



    /**
     * sets up all scores in a won / played configuration object
     * excludes all statused rows
     * @return object
     */
    public function convertToMerit()
    {}
}
