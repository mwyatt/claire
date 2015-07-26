<?php

namespace OriginalAppName\Site\Elttl\Service\Tennis;

/**
 */
class Result extends \OriginalAppName\Service
{


    /**
     * convert fixtures and encounters to fixture results
     * @param  array $entFixtures
     * @param  array $entEncounters
     * @return array
     */
    public function getFixture($entFixtures, $entEncounters)
    {
        $results = [];
        foreach ($entEncounters as $entEncounter) {
            $fixtureId = $entEncounter->fixtureId;
            if (empty($results[$fixtureId])) {
                $results[$fixtureId] = new \OriginalAppName\Site\Elttl\Entity\Tennis\Result\Fixture;
            }

            // get scores
            $results[$fixtureId]->scoreLeft += $entEncounter->scoreLeft;
            $results[$fixtureId]->scoreRight += $entEncounter->scoreRight;
        }
        return $results;
    }


    public function getSummaryTable($entityYear, $entityDivision)
    {

        // teams in division keyed by teamId
        $modelTeam = new \OriginalAppName\Site\Elttl\Model\Tennis\Team;
        $modelTeam
            ->readYearColumn($entityYear->id, 'divisionId', $entityDivision->id)
            ->keyDataByProperty('id');

        // fixtures teams have played in
        // only need left side
        $modelFixture = new \OriginalAppName\Site\Elttl\Model\Tennis\Fixture;
        $modelFixture->readYearId($entityYear->id, $modelTeam->getDataProperty('id'), 'teamIdLeft');

        // encounters based on fixtures
        $modelEncounter = new \OriginalAppName\Site\Elttl\Model\Tennis\Encounter;
        $modelEncounter->readYearId($entityYear->id, $modelFixture->getDataProperty('id'), 'fixtureId');

        $serviceResult = new \OriginalAppName\Site\Elttl\Service\Tennis\Result;
        $fixtureResults = $serviceResult->getFixture($modelFixture->getData(), $modelEncounter->getData());

        // template
        return [
            'fixtureResults' => $fixtureResults,
            'entFixtures' => $modelFixture->getData(),
            'entTeams' => $modelTeam->getData()
        ];
    }


    /**
     * work in progress
     */
    public function getLeague($modelFixture, $modelEncounter)
    {
        $modelFixture->keyDataByProperty('id');
        if (! $entitiesFixture = $modelFixture->getData()) {
            return [];
        }
        $collection = [];
        foreach ($modelEncounter->getData() as $key => $fixtureScore) {
            if (! array_key_exists($key, $entitiesFixture)) {
                return $modelFixture;
            }
            foreach (array('left', 'right') as $side) {
                $teamId = $entitiesFixture[$key]->{'team_id_' . $side};
                $scores = $modelEncounter->getData($key);

                // init key for team
                if (! array_key_exists($teamId, $collection)) {
                    $collection[$teamId] = (object) array(
                        'won' => 0,
                        'draw' => 0,
                        'loss' => 0,
                        'played' => 0,
                        'points' => 0
                    );
                }

                // get scores
                $score = $scores->{'score_' . $side};
                $opposingScore = $scores->{'score_' . $modelFixture->getOtherSide($side)};

                // calculate won, loss, played, points
                $collection[$teamId]->played ++;
                $collection[$teamId]->points += $score;

                // draw
                if ($score == $opposingScore) {
                    $collection[$teamId]->draw ++;
                    continue;
                }

                // won
                if ($score > $opposingScore) {
                    $collection[$teamId]->won ++;
                    continue;

                // loss
                } else {
                    $collection[$teamId]->loss ++;
                }
            }
        }
        $modelFixture->setData($collection);
        return $this;
    }
}
