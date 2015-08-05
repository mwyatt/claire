<?php

namespace OriginalAppName\Site\Elttl\Controller;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Result extends \OriginalAppName\Site\Elttl\Controller\Front
{


    public $division;


    /**
     * every year past and present for the league
     * @return object
     */
    public function yearAll()
    {
        $serviceYear = new \OriginalAppName\Site\Elttl\Service\Tennis\Year;
        $this
            ->view
            ->setDataKey('metaTitle', 'All seasons')
            ->setDataKey('years', $serviceYear->read());
        return new \OriginalAppName\Response($this->view->getTemplate('result/_year-all'));
    }


    /**
     * list of all divisions for current year
     * @return null
     */
    public function yearSingle($yearName)
    {
        $serviceYear = new \OriginalAppName\Site\Elttl\Service\Tennis\Year;
        if (!$entityYear = $serviceYear->readName($yearName)) {
            return new \OriginalAppName\Response('', 404);
        }

        // division
        $modelDivision = new \OriginalAppName\Site\Elttl\Model\Tennis\Division;
        $modelDivision->readColumn('yearId', $entityYear->id);

        // template
        $this
            ->view
            ->setDataKey('metaTitle', 'Divisions in season ' . $entityYear->getNameFull())
            ->setDataKey('divisions', $modelDivision->getData())
            ->setDataKey('yearSingle', $entityYear);
        return new \OriginalAppName\Response($this->view->getTemplate('result/_year-single'));
    }


    /**
     * options for merit, league etc
     * @return object
     */
    public function yearDivisionSingle($yearName, $divisionName)
    {
        $serviceYear = new \OriginalAppName\Site\Elttl\Service\Tennis\Year;
        if (!$entityYear = $serviceYear->readName($yearName)) {
            return new \OriginalAppName\Response('', 404);
        }

        // division
        $modelDivision = new \OriginalAppName\Site\Elttl\Model\Tennis\Division;
        $modelDivision->readYearColumn($entityYear->id, 'name', $divisionName);
        if (!$entityDivision = $modelDivision->getDataFirst()) {
            return new \OriginalAppName\Response('', 404);
        }

        // fixture summary table
        $serviceResult = new \OriginalAppName\Site\Elttl\Service\Tennis\Result;
        $summaryTableParts = $serviceResult->getSummaryTable($entityYear, $entityDivision);

        // single division view
        $this->view
            ->setDataKey('metaTitle', $entityDivision->name . ' division overview')
            ->setDataKey('fixtureResults', $summaryTableParts['fixtureResults'])
            ->setDataKey('teams', $summaryTableParts['entTeams'])
            ->setDataKey('fixtures', $summaryTableParts['entFixtures'])
            ->setDataKey('fixtures', $summaryTableParts['entFixtures'])
            ->setDataKey('yearSingle', $entityYear)
            ->setDataKey('division', $entityDivision);
        return new \OriginalAppName\Response($this->view->getTemplate('result/_division-single'));
    }


    public function yearDivisionLeague($yearName, $divisionName)
    {
        $serviceResult = new \OriginalAppName\Site\Elttl\Service\Tennis\Result;
        $serviceYear = new \OriginalAppName\Site\Elttl\Service\Tennis\Year;
        if (!$entityYear = $serviceYear->readName($yearName)) {
            return new \OriginalAppName\Response('', 404);
        }

        // division
        $modelDivision = new \OriginalAppName\Site\Elttl\Model\Tennis\Division;
        $modelDivision->readYearColumn($entityYear->id, 'name', $divisionName);
        if (!$division = $modelDivision->getDataFirst()) {
            return new \OriginalAppName\Response('', 404);
        }

        // team
        $modelTeam = new \OriginalAppName\Site\Elttl\Model\Tennis\Team;
        $modelTeam->readYearColumn($entityYear->id, 'divisionId', $division->id);
        $modelTeam->keyDataByProperty('id');

        // fixture
        $modelTennisFixture = new \OriginalAppName\Site\Elttl\Model\Tennis\Fixture;
        $modelTennisFixture->readYearId($entityYear->id, $modelTeam->getDataProperty('id'), 'teamIdLeft');

        // encounter
        $modelTennisEncounter = new \OriginalAppName\Site\Elttl\Model\Tennis\Encounter;
        $modelTennisEncounter->readYearId($entityYear->id, $modelTennisFixture->getDataProperty('id'), 'fixtureId');
        
        // league table
        echo '<pre>';
        print_r($serviceResult->getLeague($modelTennisFixture, $modelTennisEncounter));
        echo '</pre>';
        exit;
        
        // orderByProperty

        // template
        $this->view
            ->setMeta(array(
                'title' => $division->getName() . ' League'
            ))
            ->setDataKey('division', $division)
            ->setDataKey('teams', $modelTeam->getData())
            ->setDataKey('tableName', 'league')
            ->setDataKey('leagueStats', $modelTennisFixture->getData())
            ->getTemplate('division/league');
    }


    public function resultYearDivisionMeritDoubles()
    {
        
        // resource
        $division = $this->getDivision();

        // team
        $className = $this->getArchiveClassName('model_tennis_team');
        $modelTennisTeam = new $className($this);
        $modelTennisTeam->read($this->getArchiveWhere(array(
            'where' => array('division_id' => $division->getId())
        )));
        $modelTennisTeam->keyDataByProperty('id');

        // fixture
        $className = $this->getArchiveClassName('model_tennis_fixture');
        $modelTennisFixture = new $className($this);
        $modelTennisFixture->read($this->getArchiveWhere(array(
            'where' => array('team_id_left' => $modelTennisTeam->getDataProperty('id'))
        )));

        // encounter
        $className = $this->getArchiveClassName('model_tennis_encounter');
        $modelTennisEncounter = new $className($this);
        $modelTennisEncounter->read($this->getArchiveWhere(array(
            'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
        )));

        // convert encounters to merit results
        $modelTennisEncounter
            ->filterStatus(array('', 'exclude'))
            ->convertToFixtureResults();

        // convert encounter conversion, keyed by team id
        $modelTennisFixture
            ->convertToLeague($modelTennisEncounter->getData())
            ->orderByHighestPoints();

        // template
        $this->view
            ->setMeta(array(
                'title' => $division->getName() . ' doubles merit'
            ))
            ->setDataKey('division', $division)
            ->setDataKey('tableName', 'doubles merit')
            ->setDataKey('teams', $modelTennisTeam->getData())
            ->setDataKey('leagueStats', $modelTennisFixture->getData())
            ->getTemplate('division/league');
    }


    public function resultYearDivisionMerit()
    {
        if ($this->getArchivePathPart(3) == 'doubles') {
            return $this->meritDoubles();
        }

        // resource
        $division = $this->getDivision();

        // team
        $className = $this->getArchiveClassName('model_tennis_team');
        $modelTennisTeam = new $className($this);
        $modelTennisTeam->read($this->getArchiveWhere(array(
            'where' => array('division_id' => $division->getId())
        )));
        $modelTennisTeam->keyDataByProperty('id');

        // players
        $className = $this->getArchiveClassName('model_tennis_player');
        $modelTennisPlayer = new $className($this);
        $modelTennisPlayer->read($this->getArchiveWhere(array(
            'where' => array('team_id' => $modelTennisTeam->getDataProperty('id'))
        )));
        $modelTennisPlayer->keyDataByProperty('id');

        // fixture
        $className = $this->getArchiveClassName('model_tennis_fixture');
        $modelTennisFixture = new $className($this);
        $modelTennisFixture->read($this->getArchiveWhere(array(
            'where' => array('team_id_left' => $modelTennisTeam->getDataProperty('id'))
        )));

        // encounter
        $className = $this->getArchiveClassName('model_tennis_encounter');
        $modelTennisEncounter = new $className($this);
        $modelTennisEncounter->read($this->getArchiveWhere(array(
            'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
        )));

        // convert encounters to merit results
        $modelTennisEncounter
            ->filterStatus(array('doubles', 'exclude'))
            ->convertToMerit()
            ->orderByHighestAverage();

        // template
        $this->view
            ->setMeta(array(
                'title' => $division->getName() . ' Merit'
            ))
            ->setDataKey('division', $division)
            ->setDataKey('teams', $modelTennisTeam->getData())
            ->setDataKey('players', $modelTennisPlayer->getData())
            ->setDataKey('meritStats', $modelTennisEncounter->getData())
            ->getTemplate('division/merit');
    }


    /**
     * @return object OriginalAppName\\OriginalAppName\Site\Elttl\Entity\Tennis\Division
     */
    public function getDivision()
    {
        return $this->division;
    }
    
    
    /**
     * @param object $year OriginalAppName\\OriginalAppName\Site\Elttl\Entity\Tennis\Division
     */
    public function setDivision($division)
    {
        $this->division = $division;
        return $this;
    }
}
