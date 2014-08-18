<?php
/*
Array
(
    [fixture_id] => 120
    [division_id] => 2
    [team] => Array
        (
            [left] => 16
            [right] => 46
        )

    [player] => Array
        (
            [left] => Array
                (
                    [1] => 56
                    [2] => 261
                    [3] => 216
                )

            [right] => Array
                (
                    [1] => 298
                    [2] => 14
                    [3] => 
                )

        )

    [encounter] => Array
        (
            [0] => Array
                (
                    [left] => 3
                    [right] => 0
                )

            [1] => Array
                (
                    [left] => 0
                    [right] => 3
                )

            [2] => Array
                (
                    [exclude] => on
                    [left] => 3
                    [right] => 0
                )

            [3] => Array
                (
                    [left] => 2
                    [right] => 3
                )

            [4] => Array
                (
                    [exclude] => on
                    [left] => 3
                    [right] => 0
                )

            [5] => Array
                (
                    [left] => 1
                    [right] => 3
                )

            [6] => Array
                (
                    [left] => 2
                    [right] => 3
                )

            [7] => Array
                (
                    [exclude] => on
                    [left] => 3
                    [right] => 0
                )

            [8] => Array
                (
                    [left] => 1
                    [right] => 3
                )

            [9] => Array
                (
                    [left] => 2
                    [right] => 3
                )

        )

)

 */

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


    /**
     * ensure correct data is present, otherwise return to single with
     * error msg
     * @return bool
     */
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
