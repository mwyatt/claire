<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Admin_Ajax_Team extends Controller_Admin
{

	
	public function run()
	{
		$this->runMethod(3);
	}


	public function create() {
		$input = $_REQUEST['team'];
		$modelTeam = new model_tennis_team($this);
		$moldTeam = new mold_tennis_Team();
		$moldTeam->setDivisionId($input['division_id']);
		$moldTeam->setName($input['name']);
		$moldTeam->setHomeWeekday($input['home_weekday']);
		$moldTeam->setVenueId($input['venue_id']);
		$moldTeam->setSecretaryId($input['secretary_id']);
		
		$insertIds = $modelTeam->create(array($moldTeam));
		if (count($insertIds)) {
			echo reset($insertIds);
		}
	}


	public function update() {
		$input = $_REQUEST['team'];
		$modelTeam = new model_tennis_team($this);
		$modelTeam->read(array(
			'where' => array('id' => $input['id'])
		));
		$moldTeam = $modelTeam->getDataFirst();
		$moldTeam->setDivisionId($input['division_id']);
		$moldTeam->setName($input['name']);
		$moldTeam->setHomeWeekday($input['home_weekday']);
		$moldTeam->setVenueId($input['venue_id']);
		$moldTeam->setSecretaryId($input['secretary_id']);
		echo $modelTeam->update($moldTeam, array(
		    'where' => array(
		        'id' => $moldTeam->getId()
		    )
		));
	}


	public function delete() {
		$input = $_REQUEST['team'];
		$modelTeam = new model_tennis_team($this);
		echo $modelTeam->delete(array(
		    'where' => array('id' => $input['id'])
		));
	}
}
