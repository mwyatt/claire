<?php

namespace OriginalAppName\Site\Elttl\Controller;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Player extends \OriginalAppName\Site\Elttl\Controller\Front
{


    public function single($yearName, $playerSlug)
    {
        $serviceResult = new \OriginalAppName\Site\Elttl\Service\Tennis\Result;
        $modPlayer = new \OriginalAppName\Site\Elttl\Model\Tennis\Player;

        // year
        $serviceYear = new \OriginalAppName\Site\Elttl\Service\Tennis\Year;
        if (!$entityYear = $serviceYear->readName($yearName)) {
            return new \OriginalAppName\Response('', 404);
        }

        // player
        $modPlayer->readYearColumn($entityYear->id, 'slug', $playerSlug);
        if (!$player = $modPlayer->getDataFirst()) {
            return new \OriginalAppName\Response('', 404);
        }

        // team
        $modTeam = new \OriginalAppName\Site\Elttl\Model\Tennis\Team;
        $modTeam->readYearId($entityYear->id, [$player->teamId]);
        if (!$team = $modTeam->getDataFirst()) {
            return new \OriginalAppName\Response('', 404);
        }

        // division
        $modDivision = new \OriginalAppName\Site\Elttl\Model\Tennis\Division;
        $modDivision->readYearId($entityYear->id, [$team->divisionId]);
        if (!$division = $modDivision->getDataFirst()) {
            return new \OriginalAppName\Response('', 404);
        }

        // encounter
        $modEncounter = new \OriginalAppName\Site\Elttl\Model\Tennis\Encounter;
        $modEncounter->readYearId($entityYear->id, [$player->id], 'playerIdLeft');
        $encounters = $modEncounter->getData();
        $modEncounter->readYearId($entityYear->id, [$player->id], 'playerIdRight');
        $modEncounter->setData(array_merge($encounters, $modEncounter->getData()));
        $modEncounter->filterStatus(['doubles', 'exclude']);
        $modPersonalEncounters = $modEncounter->orderByProperty('id');

        // merit
        $meritRows = $serviceResult->getMerit($modEncounter->getData());

        // players (the team)
        $modPlayer->readYearColumn($entityYear->id, 'teamId', $team->id);
        $acquaintances = $modPlayer->getData();
    
        // fixtures
        $fixtureIds = $modPersonalEncounters->getDataProperty('fixtureId');
        $modFixture = new \OriginalAppName\Site\Elttl\Model\Tennis\Fixture;
        $modFixture->readYearId($entityYear->id, $fixtureIds);
        $modFixture->orderByProperty('timeFulfilled', 'desc');
        $fixtures = $modFixture->getData();

        // players within fixtures
        if (!empty($fixtures)) {
            $teamIds = array_merge($modFixture->getDataProperty('teamIdLeft'), $modFixture->getDataProperty('teamIdRight'));
            $modPlayer
                ->readYearId($entityYear->id, $teamIds, 'teamId')
                ->keyDataByProperty('id');
        }

        // teams
        if (!empty($fixtures)) {
            $modTeam
                ->readYearId($entityYear->id, $teamIds, 'id')
                ->keyDataByProperty('id');
        }
        $teams = $modTeam->getData();

        // all fixtures played in encounters
        $modEncounter->readYearId($entityYear->id, $fixtureIds, 'fixtureId');
        $fixtureResults = $serviceResult->getFixture($modFixture->getData(), $modEncounter->getData());

        // template
        $this->view
            ->setMeta(array(
                'title' => 'Player ' . $player->getNameFull()
            ))
            ->setDataKey('yearSingle', $entityYear)
            ->setDataKey('meritRows', $meritRows)
            ->setDataKey('division', $modDivision->getDataFirst())
            ->setDataKey('player', $player)
            ->setDataKey('players', $modPlayer->getData())
            ->setDataKey('team', $team)
            ->setDataKey('teams', $teams)
            ->setDataKey('acquaintances', $acquaintances)
            ->setDataKey('year', $entityYear)
            ->setDataKey('fixtures', $fixtures)
            ->setDataKey('fixtureResults', $fixtureResults)
            ->setDataKey('encounters', $modPersonalEncounters->getData());
        return new \OriginalAppName\Response($this->view->getTemplate('player-single'));
    }
}
