<?php

namespace OriginalAppName\Site\Elttl\Admin\Controller\System;

use OriginalAppName;
use OriginalAppName\Registry;
use OriginalAppName\Response;
use OriginalAppName\Session;
use OriginalAppName\Model;
use OriginalAppName\Admin\Service;
use OriginalAppName\Site\Elttl\Model\Tennis as ModelTennis;
use OriginalAppName\Site\Elttl\Entity\Tennis as EntityTennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Tennis extends \OriginalAppName\Controller\Admin
{


	/**
	 * @return object Response
	 */
	public function all() {
		if (! empty($_GET['newSeason'])) {
			$this->newSeason();
		}

		// $this
		// 	->view
		// 	->setDataKey('versionsUnpatched', $versionsUnpatched);
		return new Response($this->view->getTemplate('admin/system/tennis/all'));
	}


	/**
	 * copies across all that is required, then moves yearId option forwards
	 * @return null set feedback and redirect
	 */
	public function newSeason()
	{

		// get current year and next one
		$registry = Registry::getInstance();
		$modelYear = new ModelTennis\Year;
		$modelYear->readColumn('id', $registry->get('database/options/yearId'));
		$entityYear = $modelYear->getDataFirst();
		$yearIdNew = $entityYear->id + 1;

		// duplicate
		$things = ['division', 'team', 'player', 'venue'];
		foreach ($things as $thing) {
			$class = "\\OriginalAppName\\Site\\Elttl\\Model\\Tennis\\" . ucfirst($thing);
			$model = new $class;
			$model->readColumn('yearId', $entityYear->id);
			$entities = $model->getData();
			foreach ($entities as $entity) {
				$entity->yearId = $yearIdNew;
			}
			$model->duplicate($entities);
		}

		// create year
		$entityYear->name++;
		$modelYear->create([$entityYear]);
		$feedback = new Session\Feedback;

		// update option
		$modelOption = new Model\Option;
		$modelOption->readColumn('name', 'year_id');
		$entity = $modelOption->getDataFirst();
		$entity->value = $yearIdNew;
		$modelOption->update($entity, ['id' => $entity->id]);
		$feedback->setMessage("new season {$entityYear->name} created, divisions, teams, players and venues copied over" , 'positive');
		$this->redirect('admin/system/tennis');
	}


	/**
	 * todo
	 * @return [type] [description]
	 */
	public function newSeasonRevert()
	{
		// get current year and next one
		$registry = Registry::getInstance();
		$modelYear = new ModelTennis\Year;
		$modelYear->readColumn('id', $registry->get('database/options/yearId'));
		$entityYear = $modelYear->getDataFirst();
		$yearIdNew = $entityYear->id - 1;

		// duplicate
		$things = ['division', 'team', 'player', 'venue'];
		foreach ($things as $thing) {
			$class = "\\OriginalAppName\\Site\\Elttl\\Model\\Tennis\\" . ucfirst($thing);
			$model = new $class;
			$model->readColumn('yearId', $entityYear->id);
			$entities = $model->getData();
			$model->delete($model->getDataProperty('id'));
		}

		// create year
		$entityYear->name++;
		$modelYear->create([$entityYear]);
		$feedback = new Session\Feedback;

		// update option
		$modelOption = new Model\Option;
		$modelOption->readColumn('name', 'year_id');
		$entity = $modelOption->getDataFirst();
		$entity->value = $yearIdNew;
		$modelOption->update($entity, ['id' => $entity->id]);
		$feedback->setMessage("new season {$entityYear->name} created, divisions, teams, players and venues copied over" , 'positive');
		$this->redirect('admin/system/tennis');
	}


	/**
	 * todo
	 * @return [type] [description]
	 */
	public function generateFixtures()
	{

		// clear all fixtures
		$sth = $this->database->dbh->query("	
			delete from
				tennis_fixture
			where id != 0
		");

		// clear all encounters
		$sth = $this->database->dbh->query("	
			delete from
				tennis_encounter
			where id != 0
		");

		// select all divisions
		$sth = $this->database->dbh->query("	
			SELECT
				tennis_division.id as division_id
				, tennis_team.id as team_id
			FROM
				tennis_division				
			LEFT JOIN tennis_team ON tennis_division.id = tennis_team.division_id
		");
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
			$this->data[$row['division_id']][] = $row['team_id'];
		}						
		$sth = $this->database->dbh->prepare("
			INSERT INTO
				tennis_fixture
				(team_id_left, team_id_right)
			VALUES
				(:team_id_left, :team_id_right)
		");				
				
		// loop to set team vs team fixtures
		foreach ($this->data as $division) {
			foreach ($division as $key => $homeTeam) {
				foreach ($division as $key => $awayTeam) {
					if ($homeTeam !== $awayTeam) {
						$sth->execute(array(
							':team_id_left' => $homeTeam
							, ':team_id_right' => $awayTeam
						));					
					}
				}
			}
		}

		// feedback
		echo '<pre>';
		print_r('all fixtures and encounters removed, and fixtures re-generated using current team configuration');
		echo '</pre>';
		exit;
	}
}
