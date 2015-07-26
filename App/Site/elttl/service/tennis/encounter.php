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
    {
        if (! $molds = $this->getData()) {
            return $this;
        }
        $collection = array();
        foreach ($molds as $mold) {
            foreach (array('left', 'right') as $side) {
                // create object entry for player if not exist
                $playerId = $mold->{'player_id_' . $side};
                if (! array_key_exists($playerId, $collection)) {
                    $collection[$playerId] = (object) array(
                        'won' => 0,
                        'played' => 0,
                        'average' => null
                    );
                }

                // get scores
                $score = $mold->{'score_' . $side};
                $opposingScore = $mold->{'score_' . $this->getOtherSide($side)};

                // adding only your points
                $collection[$playerId]->won += $score;

                // totaling win and other side score
                $collection[$playerId]->played += ($score + $opposingScore);
            }
        }

        // inject average
        foreach ($collection as $key => $singleCurated) {
            $collection[$key]->average = $this->calcAverage($singleCurated->won, $singleCurated->played);
        }

        // return [playerid], won, played, average objects
        $this->setData($collection);
        return $this;
    }
}
