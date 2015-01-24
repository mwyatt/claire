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
			->keyDataByProperty('id')
			->orderByPropertyStringAsc('name');

		// template
		$this->view
			->setDataKey('weekdays', $modelTennisTeam->getWeekdays())
			->setDataKey('teams', $modelTennisTeam->getData())
			->setDataKey('divisions', $modelTennisDivision->getData())
			->setDataKey('venues', $modelTennisVenue->getData())
			->setDataKey('players', $modelTennisPlayer->getData())
			->getTemplate('admin/tennis/team/list');
	}
}
