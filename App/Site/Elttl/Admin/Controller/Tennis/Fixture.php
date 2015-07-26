<?php
namespace OriginalAppName\Site\Elttl\Admin\Controller\Tennis;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Fixture extends \OriginalAppName\Site\Elttl\Admin\Controller\Tennis\Crud
{


    public function create()
    {
        $this->update(null);
    }


    /**
     * @return object
     */
    public function all()
    {
        $modelTennisFixture = new \OriginalAppName\Site\Elttl\Model\Tennis\Fixture;
        $modelTennisFixture
            ->readColumn('yearId', $this->yearId)
            ->orderByProperty('teamIdLeft', 'desc');
        $modelTennisTeam = new \OriginalAppName\Site\Elttl\Model\Tennis\Team;
        $modelTennisTeam
            ->readColumn('yearId', $this->yearId)
            ->keyDataByProperty('id');
        $modelTennisDivision = new \OriginalAppName\Site\Elttl\Model\Tennis\Division;
        $modelTennisDivision->readColumn('yearId', $this->yearId);
        $this->view
            ->setDataKey('divisions', $modelTennisDivision->getData())
            ->setDataKey('fixtures', $modelTennisFixture->getData())
            ->setDataKey('teams', $modelTennisTeam->getData());
        return new \OriginalAppName\Response($this->view->getTemplate("admin/tennis/{$this->nameSingular}/all"));
    }


    public function single($id = 0)
    {

        // flag to know if filled, why?
        $isFilled = false;

        // get single fixture
        $modelTennisFixture = new \OriginalAppName\Site\Elttl\Model\Tennis\Fixture;
        $modelTennisFixture->readYearColumn(null, 'id', $id);
        $fixture = $modelTennisFixture->getDataFirst();
        
        // find out if the fixture has been filled
        $modelTennisEncounter = new \OriginalAppName\Site\Elttl\Model\Tennis\Encounter;
        $modelTennisEncounter->readYearColumn(null, 'fixtureId', $id);
        if ($modelTennisEncounter->getData()) {
            $modelTennisEncounter->orderByProperty('id');
            $isFilled = true;
        }

        // teams
        $modelTennisTeam = new \OriginalAppName\Site\Elttl\Model\Tennis\Team;
        if ($isFilled) {
            $modelTennisTeam->readYearId(null, [$fixture->teamIdLeft, $fixture->teamIdRight]);
        } else {
            $modelTennisTeam->readColumn('yearId', $this->yearId);
        }

        // divisions
        $modelTennisDivision = new \OriginalAppName\Site\Elttl\Model\Tennis\Division;
        if ($isFilled) {
            $modelTennisDivision->readYearId(null, $modelTennisTeam->getDataProperty('divisionId'));
        } else {
            $modelTennisDivision->readColumn('yearId', $this->yearId);
        }

        // player
        $modelTennisPlayer = new \OriginalAppName\Site\Elttl\Model\Tennis\Player;
        if ($isFilled) {
            $modelTennisPlayer
                ->readYearId(null, $modelTennisTeam->getDataProperty('id'), 'teamId')
                ->orderByProperty('rank');
        } else {
            $modelTennisPlayer
                ->readColumn('yearId', $this->yearId)
                ->orderByProperty('nameLast', 'desc');
        }

        // reindex array, needed?
        $modelTennisPlayer->setData(array_values($modelTennisPlayer->getData()));

        // template
        $this->view
            ->appendAsset('css', 'admin/tennis/fixture/single')
            ->appendAsset('js', 'admin/tennis/fixture/single')
            ->setDataKey('sides', ['left', 'right'])
            ->setDataKey('isFilled', $isFilled)
            ->setDataKey('fixture', $fixture)
            ->setDataKey('divisions', $modelTennisDivision->getData())
            ->setDataKey('teams', $modelTennisTeam->getData())
            ->setDataKey('players', $modelTennisPlayer->getData())
            ->setDataKey('encounters', $modelTennisEncounter->getData())
            ->setDataKey('encounterStructure', $modelTennisFixture->getEncounterStructure());
        return new \OriginalAppName\Response($this->view->getTemplate('admin/tennis/fixture/single'));
    }


    public function update($id)
    {
        $service = new \OriginalAppName\Site\Elttl\Admin\Service\Tennis\Fixture\Fulfill;
        $service->boot();
        $this->redirect('admin/tennis/fixture/create');
    }
}
