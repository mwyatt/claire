<?php

namespace OriginalAppName\Site\Elttl\Controller;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Fixture extends \OriginalAppName\Site\Elttl\Controller\Front
{


    public function single($yearName, $teamLeftSlug, $teamRightSlug)
    {

        // year
        $serviceYear = new \OriginalAppName\Site\Elttl\Service\Tennis\Year;
        if (!$entityYear = $serviceYear->readName($yearName)) {
            return new \OriginalAppName\Response('', 404);
        }

        // team left
        $modTeam = new \OriginalAppName\Site\Elttl\Model\Tennis\Team;
        $modTeam->readYearColumn($entityYear->id, 'slug', $teamLeftSlug);
        if (!$teamLeft = $modTeam->getDataFirst()) {
            return new \OriginalAppName\Response('', 404);
        }

        // team right
        $modTeam = new \OriginalAppName\Site\Elttl\Model\Tennis\Team;
        $modTeam->readYearColumn($entityYear->id, 'slug', $teamRightSlug);
        if (!$teamRight = $modTeam->getDataFirst()) {
            return new \OriginalAppName\Response('', 404);
        }
        $teamIds = [$teamLeft->id, $teamRight->id];

        // players
        $modPlayer = new \OriginalAppName\Site\Elttl\Model\Tennis\Player;
        $modPlayer->readYearId($entityYear->id, $teamIds, 'teamId');
        if (!$players = $modPlayer->keyDataByProperty('id')->getData()) {
            return new \OriginalAppName\Response('', 404);
        }

        // division
        $modDivision = new \OriginalAppName\Site\Elttl\Model\Tennis\Division;
        $modDivision->readYearId($entityYear->id, [$teamLeft->divisionId]);

        // fixture
        $modFixture = new \OriginalAppName\Site\Elttl\Model\Tennis\Fixture;
        $modFixture->readYearId($entityYear->id, [$teamLeft->id], 'teamIdLeft');
        foreach ($modFixture->getData() as $entityFixture) {
            if ($entityFixture->teamIdRight == $teamRight->id) {
                $fixture = $entityFixture;
            }
        }
        if (empty($fixture)) {
            return new \OriginalAppName\Response('', 404);
        }

        // must be fulfilled
        if (!$fixture->timeFulfilled) {
            return new \OriginalAppName\Response('', 404);
        }

        // encounter
        $modEncounter = new \OriginalAppName\Site\Elttl\Model\Tennis\Encounter;
        $modEncounter->readYearId($entityYear->id, [$fixture->id], 'fixtureId');
        $modEncounter->orderByProperty('id');
        $encounters = $modEncounter->getData();

        // fixture results
        $serviceResult = new \OriginalAppName\Site\Elttl\Service\Tennis\Result;
        $fixtureResults = $serviceResult->getFixture([$fixture], $encounters);

        // template
        $this->view
            ->setMeta(array(
                'title' => $teamLeft->name . ' vs ' . $teamRight->name
            ))
            ->setDataKey('yearSingle', $entityYear)
            ->setDataKey('teamLeft', $teamLeft)
            ->setDataKey('teamRight', $teamRight)
            ->setDataKey('division', $modDivision->getDataFirst())
            ->setDataKey('fixture', $fixture)
            ->setDataKey('fixtureResult', reset($fixtureResults))
            ->setDataKey('encounters', $encounters)
            ->setDataKey('players', $players);
        return new \OriginalAppName\Response($this->view->getTemplate('fixture-single'));
    }
}
