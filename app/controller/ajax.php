<?php

/**
 * ajax
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

class Controller_Ajax extends Controller
{

	public function index($action) {
		$this->config->getObject('Route')->home();
	}


	public function division($action) {
		$output = '';

		// get teams by division id

		if (array_key_exists('id', $_POST)) {

			$ttTeam = new ttTeam($database, $config);

			$ttTeam->readByDivision($_POST['division_id']);

			if ($ttTeam->getData()) {	

				$output .= '<option value="0"></option>';

				while ($ttTeam->nextRow()) {
			
					$output .= '<option value="' . $ttTeam->getRow('team_id') . '">' . $ttTeam->getRow('team_name') . '</option>';

				}

			}

		}

		echo $output;
	}

	public function search($action) {
		if (array_key_exists('default', $_GET)) {
			$search = new Search($database, $config);
			if ($search->read($_GET['default']))
				echo $search->getData();
		}
	}
	
}
