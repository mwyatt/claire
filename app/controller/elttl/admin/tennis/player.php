<?php


/**
 * currently only utilised for ajax, how to make this multifunctional?
 * does it need to be?
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Admin_Tennis_Player extends Controller_Admin
{


	public function run()
	{
		$this->read();
	}


	/**
	 * get list of all
	 * @return null 
	 */
	public function read()
	{
		$modelTennisPlayer = new model_tennis_player($this);
		$modelTennisPlayer
			->read()
			->orderByPropertyStringAsc('name_last');
		$modelTennisTeam = new model_tennis_team($this);
		$modelTennisTeam
			->read()
			->keyByProperty('id')
			->orderByPropertyStringAsc('name');
		$this->view
			->setObject('players', $modelTennisPlayer->getData())
			->setObject('teams', $modelTennisTeam->getData())
			->getTemplate('admin/tennis/player/list');
	}


	/**
	 * fill empty mold with create or update data from request
	 * @return object 
	 */
	public function getMold()
	{
		$modelTennisPlayer = new model_tennis_player($this);
		$mold = new mold_tennis_player();
		$mold->setId();
		$mold->setTeamId();
		$mold->setNameFirst();
		$mold->setNameLast();
		$mold->setRank();
		$mold->setPhoneLandline();
		$mold->setPhoneMobile();
		$mold->setEttaLicenseNumber();
		return $mold;
	}


	/**
	 * create a row
	 * @return null 
	 */
	public function create()
	{
		$modelTennisPlayer = new model_tennis_player($this);
		$mold = $this->getMold();
		$affectedRows = $modelTennisPlayer->create(array($mold));
		$sessionFeedback = new session_feedback($this);
		$sessionFeedback->set('Player created');
		if ($affectedRows) {
			echo 'success';
		}
	}


	/**
	 * update a row
	 * @return null 
	 */
	public function update()
	{
		$modelTennisPlayer = new model_tennis_player($this);
		$mold = $this->getMold();
		$affectedRows = $modelTennisPlayer->update($mold, array(
			'where' => array(
				'id' => $_REQUEST['player_id']
			)
		));
		if ($affectedRows) {
			echo 'success';
		}
	}


	/**
	 * delete a row
	 * @return null 
	 */
	public function delete()
	{
		$modelTennisPlayer = new model_tennis_player($this);
		$affectedRows = $modelTennisPlayer->delete(array(
			'where' => array(
				'id' => $_REQUEST['player_id']
			)
		));
		if ($affectedRows) {
			echo 'success';
		}
	}
}
