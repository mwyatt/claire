<?php

namespace OriginalAppName\Site\Elttl\Controller;

use OriginalAppName\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException as SymfonyResourceNotFound;
use OriginalAppName\Model;
use OriginalAppName\View;
use OriginalAppName\Site\Elttl;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Result extends \OriginalAppName\Site\Elttl\Controller\Front
{


    public $year;


    public $division;


    /**
     * requests and stores single year and division entities for
     * reference in controllers
     * @param null $request
     */
    public function __construct($request)
    {
        if (isset($request['year'])) {
            $serviceYear = new Elttl\Service\Tennis\Year();
            $this->setYear($serviceYear->readName($request['year']));
        }
        if (isset($request['division']) && $yearSingle = $this->getYear()) {
            $serviceDivision = new Elttl\Service\Tennis\Division();
            $entityDivision = $serviceDivision->readYearIdName($yearSingle->getId(), $request['division']);
            $this->setDivision($entityDivision);
        }
        \OriginalAppName\Controller::__construct();
    }


    /**
     * every year past and present for the league
     * @return object
     */
    public function resultAll($request)
    {
        $serviceYear = new Elttl\Service\Tennis\Year();

        // template
        $this
            ->view
            ->setDataKey('metaTitle', 'All seasons')
            ->setDataKey('years', $serviceYear->read());
        return new Response($this->view->getTemplate('year'));
    }


    /**
     * list of all divisions for current year
     * @return null
     */
    public function resultYear($request)
    {
        $yearSingle = $this->getYear();

        // division
        $modelDivision = new Elttl\Model\Tennis\Division();
        $modelDivision->readId([$yearSingle->getId()], 'yearId');

        // template
        $this
            ->view
            ->setDataKey('metaTitle', 'Divisions in season ' . $yearSingle->getNameFull())
            ->setDataKey('divisions', $modelDivision->getData())
            ->setDataKey('yearSingle', $yearSingle);
        return new Response($this->view->getTemplate('tennis/division-list'));
    }


    /**
     * initialises the division which is in the current url path
     * and stores in the division property
     * moves to merit || league from here
     * @return null
     */
    public function resultYearDivision($request)
    {

        // possible table request ?table=
        if (isset($_REQUEST['table'])) {
            $method = 'resultYearDivision' . ucfirst($_REQUEST['table']);
            if (method_exists($this, $method)) {
                return $this->$method();
            }
        }

        // resource
        $entityYear = $this->getYear();
        $entityDivision = $this->getDivision();
        
        // fixture summary table
        $serviceFixture = new Elttl\Service\Tennis\Fixture();
        $serviceFixture->readSummaryTable($entityYear, $entityDivision);

        // single division view
        $this->view
            ->setMeta(array(
                'title' => $division->getName() . ' division overview'
            ))
            ->setDataKey('division', $division)
            ->getTemplate('division/overview');
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


    public function resultYearDivisionLeague()
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
        $modelTennisFixture->read(array(
            'where' => array('team_id_left' => $modelTennisTeam->getDataProperty('id'))
        ));

        // encounter
        $className = $this->getArchiveClassName('model_tennis_encounter');
        $modelTennisEncounter = new $className($this);
        $modelTennisEncounter->read($this->getArchiveWhere(array(
            'where' => array('fixture_id' => $modelTennisFixture->getDataProperty('id'))
        )));

        // convert encounters to league results
        $modelTennisEncounter->convertToFixtureResults();
        $modelTennisFixture
            ->convertToLeague($modelTennisEncounter->getData())
            ->orderByHighestPoints();

        // template
        $this->view
            ->setMeta(array(
                'title' => $division->getName() . ' League'
            ))
            ->setDataKey('division', $division)
            ->setDataKey('teams', $modelTennisTeam->getData())
            ->setDataKey('tableName', 'league')
            ->setDataKey('leagueStats', $modelTennisFixture->getData())
            ->getTemplate('division/league');
    }


    /**
     * @return object OriginalAppName\Elttl\Entity\Tennis\Division
     */
    public function getDivision()
    {
        return $this->division;
    }
    
    
    /**
     * @param object $year OriginalAppName\Elttl\Entity\Tennis\Division
     */
    public function setDivision($division)
    {
        $this->division = $division;
        return $this;
    }


    /**
     * @return object OriginalAppName\Elttl\Entity\Tennis\Year
     */
    public function getYear()
    {
        return $this->year;
    }
    
    
    /**
     * @param object $year OriginalAppName\Elttl\Entity\Tennis\Year
     */
    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }
}
