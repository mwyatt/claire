<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Player extends Controller_Index
{


	public function run()
	{

		// player/martin-wyatt/
		if ($this->url->getPathPart(1)) {
			$this->single();
		}
		$this->route('base');
	}


	public function single()
	{

		// player
		$names = $this->url->getPathPart(1);
		$names = explode('-', $names);
		$modelTennisPlayer = new model_tennis_player($this);
		$modelTennisPlayer->read(array(
			'where' => array(
				'name_first' => reset($names),
				'name_last' => end($names)
			)
		));
		if (! $player = $modelTennisPlayer->getDataFirst()) {
			return;
		}

		$modelTennisTeam = new model_tennis_team($this);
		$modelTennisTeam->read(array(
			'where' => array(
				'id' => $player->getTeamId()
			)
		));


		// template
		$this->view
			->setMeta(array(		
				'title' => $division->getName() . ' League'
			))
			->setObject('division', $division)
			->setObject('teams', $modelTennisTeam->getData())
			->setObject('leagueRows', $modelTennisFixture->getData())
			->getTemplate('league');
	}
}
