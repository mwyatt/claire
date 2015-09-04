<?php

namespace OriginalAppName\Site\Elttl\Service\Tennis;

/**
 * services group up controller commands
 * making the controllers more readable and tidy
 */
class Fixture extends \OriginalAppName\Service
{


    /**
     * generates each fixture seperated by division
     * teams must not change division after this happens
     * @return null
     */
    public function generate()
    {
        $registry = \OriginalAppName\Registry::getInstance();
        $yearId = $registry->get('database/options/yearId');
        $modelFixture = new \OriginalAppName\Site\Elttl\Model\Tennis\Fixture;

        // delete all fixtures, encounters from year
        foreach (['fixture', 'encounter'] as $thing) {
            $class = "\\OriginalAppName\\Site\\Elttl\\Model\\Tennis\\" . ucfirst($thing);
            $model = new $class;
            $model->readColumn('yearId', $yearId);
            $model->deleteYear(null, $model->getDataProperty('id'));
        }

        // select all teams
        $modelTeam = new \OriginalAppName\Site\Elttl\Model\Tennis\Team;
        $modelTeam
            ->readColumn('yearId', $yearId)
            ->keyDataByProperty('id');

        // bind teams with divisions
        $divisions = [];
        foreach ($modelTeam->getData() as $team) {
            if (empty($divisions[$team->divisionId])) {
                $divisions[$team->divisionId] = [];
            }
            $divisions[$team->divisionId][$team->id] = $team;
        }

        // loop to set team vs team fixtures
        $entities = [];
        foreach ($divisions as $teams) {
            foreach ($teams as $homeTeam) {
                foreach ($teams as $awayTeam) {
                    if ($homeTeam->id !== $awayTeam->id) {
                        $entity = new \OriginalAppName\Site\Elttl\Entity\Tennis\Fixture;
                        $entity->yearId = $yearId;
                        $entity->teamIdLeft = $homeTeam->id;
                        $entity->teamIdRight = $awayTeam->id;
                        $entities[] = $entity;
                    }
                }
            }
        }
        $modelFixture->create($entities);
        return $modelFixture->getLastInsertIds();
    }
}
