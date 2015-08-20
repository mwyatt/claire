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
        $divisions = [];

        // delete all fixtures, encounters from year
        foreach (['fixture', 'encounter'] as $thing) {
            $class = "\\OriginalAppName\\Site\\Elttl\\Model\\Tennis\\" . ucfirst($thing);
            $model = new $class;
            $model->readColumn('yearId', $yearId);
            $ids = $model->getDataProperty('id');
            $model->delete($ids);
        }

        // select all teams
        $modelTeam = new \OriginalAppName\Site\Elttl\Model\Tennis\Team;
        $modelTeam
            ->readColumn('yearId', $yearId)
            ->keyDataByProperty('id');

        // bind teams with divisions
        foreach ($modelTeam->getData() as $team) {
            if (empty($divisions[$team->divisionId])) {
                $divisions[$team->divisionId] = [];
            }
            $divisions[$team->divisionId][$team->id] = $team;
        }


// here
// here
// here
// here
// here


        // prepare insert
        $sth = $this->database->dbh->prepare("
			insert into
				tennisFixture
				(
					yearId,
					teamIdLeft,
					teamIdRight
				)
			values
				(
					$yearId,
					:teamIdLeft,
					:teamIdRight
				)
		");
                
        // loop to set team vs team fixtures
        foreach ($divisions as $teams) {
            foreach ($teams as $homeTeam) {
                foreach ($teams as $awayTeam) {
                    if ($homeTeam->id !== $awayTeam->id) {
                        $sth->execute(array(
                            ':teamIdLeft' => $homeTeam->id,
                            ':teamIdRight' => $awayTeam->id
                        ));
                    }
                }
            }
        }
        return true;
    }
}
