<?php

namespace OriginalAppName\Site\Elttl\Controller;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Result extends \OriginalAppName\Controller\Front
{


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

        // year
        $serviceYear = new \OriginalAppName\Site\Elttl\Service\Tennis\Year;
        if (!$entityYear = $serviceYear->readName($yearName)) {
            return new \OriginalAppName\Response('', 404);
        }

        // am i in an archive?
        $registry = \OriginalAppName\Registry::getInstance();
        ;
        $this->view->setDataKey('isArchive', $registry->get('database/options/yearId') != $entityYear->id);

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

        // am i in an archive?
        $registry = \OriginalAppName\Registry::getInstance();
        ;
        $this->view->setDataKey('isArchive', $registry->get('database/options/yearId') != $entityYear->id);

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
            ->appendAsset('css', 'division-single')
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
        $dataContainer = new \OriginalAppName\Data;
        $serviceYear = new \OriginalAppName\Site\Elttl\Service\Tennis\Year;
        if (!$entityYear = $serviceYear->readName($yearName)) {
            return new \OriginalAppName\Response('', 404);
        }

        // am i in an archive?
        $registry = \OriginalAppName\Registry::getInstance();
        ;
        $this->view->setDataKey('isArchive', $registry->get('database/options/yearId') != $entityYear->id);

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
        $fixtureResults = $serviceResult->getFixture($modelTennisFixture->getData(), $modelTennisEncounter->getData());
        $leagueStats = $serviceResult->getLeague($fixtureResults);
        $dataContainer
            ->setData($leagueStats)
            ->orderByProperty('points', 'desc');

        // template
        $this->view
            ->setDataKey('metaTitle', $division->name . ' League')
            ->setDataKey('yearSingle', $entityYear)
            ->setDataKey('division', $division)
            ->setDataKey('teams', $modelTeam->getData())
            ->setDataKey('tableName', 'league')
            ->setDataKey('leagueStats', $dataContainer->getData());
        return new \OriginalAppName\Response($this->view->getTemplate('division/league'));
    }


    public function yearDivisionMerit($yearName, $divisionName)
    {
        $serviceResult = new \OriginalAppName\Site\Elttl\Service\Tennis\Result;
        $dataContainer = new \OriginalAppName\Data;
        $serviceYear = new \OriginalAppName\Site\Elttl\Service\Tennis\Year;
        if (!$entityYear = $serviceYear->readName($yearName)) {
            return new \OriginalAppName\Response('', 404);
        }

        // am i in an archive?
        $registry = \OriginalAppName\Registry::getInstance();
        ;
        $this->view->setDataKey('isArchive', $registry->get('database/options/yearId') != $entityYear->id);

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

        // players
        $modelPlayer = new \OriginalAppName\Site\Elttl\Model\Tennis\Player;
        $modelPlayer->readYearId($entityYear->id, $modelTeam->getDataProperty('id'), 'teamId');
        $modelPlayer->keyDataByProperty('id');

        // fixture
        $modelTennisFixture = new \OriginalAppName\Site\Elttl\Model\Tennis\Fixture;
        $modelTennisFixture->readYearId($entityYear->id, $modelTeam->getDataProperty('id'), 'teamIdLeft');

        // encounter
        $modelTennisEncounter = new \OriginalAppName\Site\Elttl\Model\Tennis\Encounter;
        $modelTennisEncounter->readYearId($entityYear->id, $modelTennisFixture->getDataProperty('id'), 'fixtureId');
        $modelTennisEncounter->filterStatus(['doubles', 'exclude']);
        $encounters = $modelTennisEncounter->getData();

        // league table
        $fixtureResults = $serviceResult->getFixture($modelTennisFixture->getData(), $modelTennisEncounter->getData());
        $meritStats = $serviceResult->getMerit($encounters);
        $dataContainer
            ->setData($meritStats)
            ->orderByProperty('average', 'desc');
        $meritStats = $dataContainer->getData();

        // template
        $this->view
            ->setDataKey('metaTitle', $division->name . ' Merit')
            ->setDataKey('yearSingle', $entityYear)
            ->setDataKey('division', $division)
            ->setDataKey('teams', $modelTeam->getData())
            ->setDataKey('players', $modelPlayer->getData())
            ->setDataKey('meritStats', $meritStats);
        return new \OriginalAppName\Response($this->view->getTemplate('division/merit'));
    }


    public function yearDivisionMeritDoubles($yearName, $divisionName)
    {
        $serviceResult = new \OriginalAppName\Site\Elttl\Service\Tennis\Result;
        $dataContainer = new \OriginalAppName\Data;
        $serviceYear = new \OriginalAppName\Site\Elttl\Service\Tennis\Year;
        if (!$entityYear = $serviceYear->readName($yearName)) {
            return new \OriginalAppName\Response('', 404);
        }

        // am i in an archive?
        $registry = \OriginalAppName\Registry::getInstance();
        ;
        $this->view->setDataKey('isArchive', $registry->get('database/options/yearId') != $entityYear->id);

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
        $modelTennisEncounter->filterStatus(['', 'exclude']);
        $encounters = $modelTennisEncounter->getData();

        // league table
        $fixtureResults = $serviceResult->getFixture($modelTennisFixture->getData(), $modelTennisEncounter->getData());
        $leagueStats = $serviceResult->getLeague($fixtureResults);
        $dataContainer
            ->setData($leagueStats)
            ->orderByProperty('points', 'desc');
        $leagueStats = $dataContainer->getData();

        // template
        $this->view
            ->setDataKey('metaTitle', $division->name . ' doubles merit')
            ->setDataKey('yearSingle', $entityYear)
            ->setDataKey('division', $division)
            ->setDataKey('tableName', 'doubles merit')
            ->setDataKey('teams', $modelTeam->getData())
            ->setDataKey('leagueStats', $leagueStats);
        return new \OriginalAppName\Response($this->view->getTemplate('division/league'));
    }
}
