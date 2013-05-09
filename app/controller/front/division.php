<?php

/**
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

class Controller_Front_Division extends Controller
{


	public function index() {
		$player = new Model_Ttplayer($this->database, $this->config);
		$team = new Model_Ttteam($this->database, $this->config);
		$fixtureResult = new Model_Ttfixture_Result($this->database, $this->config);
		$player->

echo '<pre>';
print_r($press);
echo '</pre>';
exit;


		if ($this->config->getUrl(1)) {
			if (! $press->readById($this->getId($this->config->getUrl(1)))) {
				$this->route('base', 'press/');
			}
			$this->view
				->setMeta(array(		
					'title' => $press->get('title')
					, 'keywords' => $press->get('meta_keywords')
					, 'description' => $press->get('meta_description')
				))
				->setObject($press)
				->loadTemplate('press-single');
		}
		$press->readByType('press');
		$this->view
			->setMeta(array(		
				'title' => 'All press'
				, 'keywords' => 'press, reports'
				, 'description' => 'All press currently published'
			))
			->setObject($press)
			->loadTemplate('press');







		$ttPlayer = new ttPlayer($database, $config);
		$ttTeam = new ttTeam($database, $config);
		$ttFixture = new ttFixture($database, $config);
		$ttEncounterPart = new ttEncounterPart($database, $config);
		$ttDivision->setData($division);

		$view
			->setObject($ttDivision);

		if ($config->getUrl(2)) {
			if ($config->getUrl(2) == 'merit') {
				$ttPlayer->readMerit($ttDivision->get('id'));
				$view
					->setObject($ttPlayer)
					->loadTemplate('merit');
			}
			if ($config->getUrl(2) == 'league') {
				$ttTeam->readLeague($ttDivision->get('id'));
				$view
					->setObject($ttTeam)
					->loadTemplate('league');
			}
			if ($config->getUrl(2) == 'fixture') {
				$ttFixture->readResult($ttDivision->get('id'));
				$view
					->setObject($ttFixture)
					->loadTemplate('fixture');
			}
		}
		 
		$ttPlayer->read();

		$view
			->setObject($ttPlayer)
			->loadTemplate('division');
	}

	
}
