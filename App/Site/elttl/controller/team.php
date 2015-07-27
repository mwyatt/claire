<?php

namespace OriginalAppName\Site\Elttl\Controller;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Team extends \OriginalAppName\Site\Elttl\Controller\Front
{


    public function single($yearName, $teamSlug)
    {
        $serviceResult = new \OriginalAppName\Site\Elttl\Service\Tennis\Result;
        $serviceYear = new \OriginalAppName\Site\Elttl\Service\Tennis\Year;
        if (!$entityYear = $serviceYear->readName($yearName)) {
            return new \OriginalAppName\Response('', 404);
        }

        // team
        $modelTennisTeam = new \OriginalAppName\Site\Elttl\Model\Tennis\Team;
        $modelTennisTeam->readYearColumn($entityYear->id, 'slug', $teamSlug);
        if (!$team = $modelTennisTeam->getDataFirst()) {
            return new \OriginalAppName\Response('', 404);
        }

        // players
        $modelTennisPlayer = new \OriginalAppName\Site\Elttl\Model\Tennis\Player;
        $modelTennisPlayer->readYearId($entityYear->id, $modelTennisTeam->getDataProperty('id'), 'teamId');
        if (!$players = $modelTennisPlayer->getData()) {
            return new \OriginalAppName\Response('', 404);
        }

        // secretary
        $modelTennisPlayer->readYearId($entityYear->id, [$team->secretaryId]);
        $secretary = $modelTennisPlayer->getDataFirst();

        // division
        $modelTennisDivision = new \OriginalAppName\Site\Elttl\Model\Tennis\Division;
        $modelTennisDivision->readYearId($entityYear->id, [$team->divisionId]);

        // fixture
        $modelTennisFixture = new \OriginalAppName\Site\Elttl\Model\Tennis\Fixture;
        $modelTennisFixture->readYearId($entityYear->id, [$team->id], 'teamIdLeft');
        $fixturesLeft = $modelTennisFixture->getData();
        $modelTennisFixture->readYearId($entityYear->id, [$team->id], 'teamIdRight');
        $fixturesRight = $modelTennisFixture->getData();
        $fixtures = array_merge($fixturesLeft, $fixturesRight);
        $modelTennisFixture->setData($fixtures);

        // teams
        $modelTennisTeam = new \OriginalAppName\Site\Elttl\Model\Tennis\Team;
        $modelTennisTeam
            ->readYearId($entityYear->id, array_merge($modelTennisFixture->getDataProperty('teamIdLeft'), $modelTennisFixture->getDataProperty('teamIdRight')))
            ->keyDataByProperty('id');
        if (!$teams = $modelTennisTeam->getData()) {
            return new \OriginalAppName\Response('', 404);
        }

        // fixture results
        $modelTennisEncounter = new \OriginalAppName\Site\Elttl\Model\Tennis\Encounter;
        $modelTennisEncounter->readYearId($entityYear->id, $modelTennisFixture->getDataProperty('id'), 'fixtureId');
        $fixtureResults = $serviceResult->getFixture($modelTennisFixture->getData(), $modelTennisEncounter->getData());

        // venue
        $modelTennisVenue = new \OriginalAppName\Site\Elttl\Model\Tennis\Venue;
        $modelTennisVenue->readYearId($entityYear->id, [$team->venueId]);
        $venue = $modelTennisVenue->getDataFirst();

        // template
        $this->view
            ->setMeta(array(
                'title' => $team->name
            ))
            ->setDataKey('team', $team)
            ->setDataKey('teams', $teams)
            ->setDataKey('venue', $venue)
            ->setDataKey('division', $modelTennisDivision->getDataFirst())
            ->setDataKey('secretary', $secretary)
            ->setDataKey('fixtures', $modelTennisFixture->getData())
            ->setDataKey('fixtureResults', $fixtureResults)
            ->setDataKey('players', $players);
        return new \OriginalAppName\Response($this->view->getTemplate('team-single'));
    }
}
