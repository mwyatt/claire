<?php

namespace OriginalAppName\Site\Elttl\Service\Tennis;

/**
 * services group up controller commands
 * making the controllers more readable and tidy
 */
class Fixture extends \OriginalAppName\Service
{


    public function readSummaryTable($entityYear, $entityDivision)
    {

        // teams in division keyed by teamId
        $modelTeam = new \OriginalAppName\Site\Elttl\Model\Tennis\Team;
        $modelTeam
            ->readColumn('yearId', $entityYear->id)
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
        $this
            ->view
            ->setDataKey('fixtureResults', $fixtureResults)
            ->setDataKey('fixtures', $modelFixture->getData())
            ->setDataKey('teams', $modelTeam->getData());
    }
}
