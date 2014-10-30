<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Admin_Tennis_Team extends Controller_Admin
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

		// teams
		$modelTennisTeam = new model_tennis_Team($this);
		$modelTennisTeam
			->read()
			->orderByPropertyStringAsc('name');

		// players
		$modelTennisPlayer = new model_tennis_player($this);
		$modelTennisPlayer
			->read()
			->orderByPropertyStringAsc('name_last');

		// venues
		$modelTennisVenue = new model_tennis_Venue($this);
		$modelTennisVenue
			->read()
			->orderByPropertyStringAsc('name');

		// divisions
		$modelTennisDivision = new model_tennis_Division($this);
		$modelTennisDivision
			->read()
			->keyByProperty('id')
			->orderByPropertyStringAsc('name');

		// template
		$this->view
			->setObject('weekdays', $modelTennisTeam->getWeekdays())
			->setObject('teams', $modelTennisTeam->getData())
			->setObject('divisions', $modelTennisDivision->getData())
			->setObject('venues', $modelTennisVenue->getData())
			->setObject('players', $modelTennisPlayer->getData())
			->getTemplate('admin/tennis/team/list');
	}
}
