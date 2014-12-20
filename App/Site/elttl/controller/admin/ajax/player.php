<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Admin_Ajax_Player extends Controller_Admin
{

	
	public function run()
	{
		$this->runMethod(3);
		exit;
	}


	public function create() {
		$input = $_REQUEST['player'];
		$modelPlayer = new model_tennis_player($this);
		$moldPlayer = new mold_tennis_player();
		$moldPlayer->setTeamId($input['team_id']);
		$moldPlayer->setNameFirst($input['name_first']);
		$moldPlayer->setNameLast($input['name_last']);
		$moldPlayer->setRank($input['rank']);
		$moldPlayer->setPhoneLandline($input['phone_landline']);
		$moldPlayer->setPhoneMobile($input['phone_mobile']);
		$moldPlayer->setEttaLicenseNumber($input['etta_license_number']);
		$insertIds = $modelPlayer->create(array($moldPlayer));
		if (count($insertIds)) {
			echo reset($insertIds);
		}
	}


	public function update() {
		$input = $_REQUEST['player'];
		$modelPlayer = new model_tennis_player($this);
		$modelPlayer->read(array(
			'where' => array('id' => $input['id'])
		));
		$player = $modelPlayer->getDataFirst();
		$player->setTeamId($input['team_id']);
		$player->setNameFirst($input['name_first']);
		$player->setNameLast($input['name_last']);
		$player->setRank($input['rank']);
		$player->setPhoneLandline($input['phone_landline']);
		$player->setPhoneMobile($input['phone_mobile']);
		$player->setEttaLicenseNumber($input['etta_license_number']);
		echo $modelPlayer->update($player, array(
		    'where' => array(
		        'id' => $player->getId()
		    )
		));
	}


	public function delete() {
		$input = $_REQUEST['player'];
		$modelPlayer = new model_tennis_player($this);
		echo $modelPlayer->delete(array(
		    'where' => array('id' => $input['id'])
		));
	}
}
