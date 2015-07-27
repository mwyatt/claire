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
        $serviceYear = new \OriginalAppName\Site\Elttl\Service\Tennis\Year;
        if (!$entityYear = $serviceYear->readName($yearName)) {
            return new \OriginalAppName\Response('', 404);
        }

        // player
        $modelTennisPlayer = new \OriginalAppName\Site\Elttl\Model\Tennis\Player;
        $modelTennisPlayer->readYearColumn($entityYear->id, 'slug', $playerSlug);
        if (!$player = $modelTennisPlayer->getDataFirst()) {
            return new \OriginalAppName\Response('', 404);
        }

        // team
        $modelTennisTeam = new \OriginalAppName\Site\Elttl\Model\Tennis\Team;
        $modelTennisTeam->readYearId($entityYear->id, [$player->teamId]);
        if (!$team = $modelTennisTeam->getDataFirst()) {
            return new \OriginalAppName\Response('', 404);
        }

        // division
        $modelTennisDivision = new \OriginalAppName\Site\Elttl\Model\Tennis\Division;
        $modelTennisDivision->readYearId($entityYear->id, [$team->divisionId]);
        if (!$division = $modelTennisDivision->getDataFirst()) {
            return new \OriginalAppName\Response('', 404);
        }


// here
// 
// 
// 
// 

        // merit
        $this->getMeritStats();

        // team mates
        $modelTennisPlayer->read($this->getArchiveWhere(array(
            'where' => array(
                'team_id' => $team->getId()
            )
        )));
        $acquaintances = $modelTennisPlayer->getData();
    
        // personal encounters
        $personalEncounters = $this->getPersonalEncounters();
        $personalEncounters->orderByPropertyIntDesc('id');

        // fixtures played in
        $fixtureIds = $personalEncounters->getDataProperty('fixture_id');
        $className = $this->getArchiveClassName('model_tennis_fixture');
        $modelTennisFixture = new $className($this);
        $modelTennisFixture->read($this->getArchiveWhere(array(
            'where' => array('id' => $fixtureIds)
        )));
        $fixtures = $modelTennisFixture->getData();

        // players from fixtures if poss
        if ($fixtures) {
            $modelTennisPlayer->read($this->getArchiveWhere(array(
                'where' => array('team_id' => array_merge($modelTennisFixture->getDataProperty('team_id_left'), $modelTennisFixture->getDataProperty('team_id_right')))
            )));
            $modelTennisPlayer->keyDataByProperty('id');
        }

        // teams
        if ($fixtures) {
            $modelTennisTeam
                ->read($this->getArchiveWhere(array(
                    'where' => array(
                        'id' => array_merge($modelTennisFixture->getDataProperty('team_id_left'), $modelTennisFixture->getDataProperty('team_id_right'))
                    )
                )))
                ->keyDataByProperty('id');
        }
        $teams = $modelTennisTeam->getData();

        // all fixtures played in encounters
        $className = $this->getArchiveClassName('model_tennis_encounter');
        $modelTennisEncounter = new $className($this);
        $modelTennisEncounter->read($this->getArchiveWhere(array(
                    'where' => array('fixture_id' => $fixtureIds)
                )));
        $modelTennisEncounter->convertToFixtureResults();
        $fixtureResults = $modelTennisEncounter->getData();

        // template
        $this->view
            ->setMeta(array(
                'title' => 'Player ' . $player->getNameFull()
            ))
            ->setDataKey('division', $modelTennisDivision->getDataFirst())
            ->setDataKey('player', $player)
            ->setDataKey('players', $modelTennisPlayer->getData())
            ->setDataKey('team', $team)
            ->setDataKey('teams', $teams)
            ->setDataKey('acquaintances', $acquaintances)
            ->setDataKey('fixtures', $fixtures)
            ->setDataKey('fixtureResults', $fixtureResults)
            ->setDataKey('encounters', $personalEncounters->getData())
            ->getTemplate('player-single');
    }


    /**
     * builds the merit table for one player specifically
     * relys on the player object being set
     * @return null
     */
    public function getMeritStats()
    {
        if (! $player = $this->getPlayer()) {
            return;
        }
        
        // encounters
        $className = $this->getArchiveClassName('model_tennis_encounter');
        $modelTennisEncounter = new $className($this);
        $modelTennisEncounter->read($this->getArchiveWhere(array(
                    'where' => array('player_id_left' => $player->getId())
                )));
        $encounters = $modelTennisEncounter->getData();
        $modelTennisEncounter->read($this->getArchiveWhere(array(
                    'where' => array('player_id_right' => $player->getId())
                )));
        $encounters = array_merge($encounters, $modelTennisEncounter->getData());
        $modelTennisEncounter->setData($encounters);
        $className = $this->getArchiveClassName('model_tennis_encounter');
        $modelTennisEncounterCopy = new $className($this);
        $modelTennisEncounterCopy->setData($encounters);
        $this->setPersonalEncounters($modelTennisEncounterCopy);

        // convert encounters to merit results
        $modelTennisEncounter
            ->filterStatus(array('doubles', 'exclude'))
            ->convertToMerit()
            ->orderByHighestAverage();

        // template
        $this->view
            ->setDataKey('meritRows', $modelTennisEncounter->getData());
    }
}
