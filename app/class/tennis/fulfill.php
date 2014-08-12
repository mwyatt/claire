<?php


/**
 * fulfill / update a fixture
 * fixture
 * player
 * encounter
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Tennis_Fulfill extends Data
{


	public function __construct()
	{
		if (! $this->validate()) {
			return;
		}
	}


	public function validate()
	{
		$global = '_REQUEST';
		$required = array(
			'division_id',
			'team',
			'player',
			'encounter'
		);
		if (! $this->arrayKeyExists($required, $$global)) {
			$this->session->set('feedback', 'Please fill all required fields');
			return false;
		}
		return true;
	}


	public function FunctionName($value='')
	{
		# code...
	}
	array($_POST['team']['left'], $_POST['team']['right'])
} 
