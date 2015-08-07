<?php

namespace OriginalAppName\Site\Elttl\Service\Tennis;

/**
 */
class Result extends \OriginalAppName\Service
{


    /**
     * convert fixtures and encounters to fixture results
     * always keyed by fixtureId
     * @param  array $entFixtures
     * @param  array $entEncounters
     * @return array
     */
    public function getFixture(Array $entFixtures, Array $entEncounters)
    {
        $results = [];

        // build fixture array
        foreach ($entFixtures as $entFixture) {
            // good idea?
            if (!$entFixture->timeFulfilled) {
                continue;
            }
            if (empty($results[$entFixture->id])) {
                $results[$entFixture->id] = new \OriginalAppName\Site\Elttl\Entity\Tennis\Result\Fixture;
            }
            $results[$entFixture->id]->teamIdLeft = $entFixture->teamIdLeft;
            $results[$entFixture->id]->teamIdRight = $entFixture->teamIdRight;
            $results[$entFixture->id]->timeFulfilled = $entFixture->timeFulfilled + 0; // need to rectify this typing
        }

        // fill with scores
        foreach ($entEncounters as $entEncounter) {
            $results[$entEncounter->fixtureId]->scoreLeft += $entEncounter->scoreLeft;
            $results[$entEncounter->fixtureId]->scoreRight += $entEncounter->scoreRight;
        }

        // data
        return $results;
    }


    public function getSummaryTable(\OriginalAppName\Site\Elttl\Entity\Tennis\Year $entityYear, \OriginalAppName\Site\Elttl\Entity\Tennis\Division $entityDivision)
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
     * compiles fixtures and encounters to create a collection of
     * keyed by teamId always
     */
    public function getLeague(Array $fixtureResults)
    {

        // collect
        $collection = [];

        // loop
        foreach ($fixtureResults as $fixtureId => $fixtureResult) {
            foreach (array('Left', 'Right') as $side) {
                $teamId = $fixtureResult->{'teamId' . $side};

                // init key for team
                if (empty($collection[$teamId])) {
                    $collection[$teamId] = new \OriginalAppName\Site\Elttl\Entity\Tennis\Result\League;
                    $collection[$teamId]->won = 0;
                    $collection[$teamId]->draw = 0;
                    $collection[$teamId]->loss = 0;
                    $collection[$teamId]->played = 0;
                    $collection[$teamId]->points = 0;
                }

                // get scores
                $score = $fixtureResult->{'score' . $side};
                $opposingScore = $fixtureResult->{'score' . ucfirst(\OriginalAppName\Site\Elttl\Helper\Tennis::getOtherSide($side))};

                // calculate won, loss, played, points
                $collection[$teamId]->played++;
                $collection[$teamId]->points += $score;

                // draw
                if ($score == $opposingScore) {
                    $collection[$teamId]->draw ++;

                // won
                } elseif ($score > $opposingScore) {
                    $collection[$teamId]->won ++;

                // loss
                } else {
                    $collection[$teamId]->loss ++;
                }
            }
        }
        return $collection;
    }


    /**
     * retreive merit objects based on entities passed
     * always keyed by playerId
     * @param  array $entEncounters
     * @return array
     */
    public function getMerit(Array $entEncounters)
    {
        $collection = [];
        foreach ($entEncounters as $entEncounter) {
            foreach (array('Left', 'Right') as $side) {

                // create object entry for player if not exist
                $playerId = $entEncounter->{'playerId' . $side};
                if (empty($collection[$playerId])) {
                    $collection[$playerId] = new \OriginalAppName\Site\Elttl\Entity\Tennis\Result\Merit;
                    $collection[$playerId]->encounter = 0;
                }

                // get scores
                $score = $entEncounter->{'score' . $side};
                $opposingScore = $entEncounter->{'score' . ucfirst(\OriginalAppName\Site\Elttl\Helper\Tennis::getOtherSide($side))};

                // adding only your points
                $collection[$playerId]->won += $score;

                // totaling win and other side score
                $collection[$playerId]->played += ($score + $opposingScore);

                // actual encounter
                $collection[$playerId]->encounter++;
            }
        }

        // inject average
        foreach ($collection as $key => $result) {
            $collection[$key]->average = \OriginalAppName\Helper::calcAverage($result->won, $result->played);
        }
        return $collection;
    }
}
