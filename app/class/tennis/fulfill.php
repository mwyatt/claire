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

/*
$modelEncounter->update(
    $mold,
    array(
        'where' => array(
            'content_id' => 10,
            'name' => 'test'
        )
    )
);

 */


    /**
     * @var object
     */
    public $fixture;


    /**
     * @var array
     */
    public $players;


    /**
     * validate and determine whether to clear first
     */
    public function run()
    {
        if (! $this->validate()) {
            return;
        }
        if (! $this->readFixture()) {
            return;
        }
        if ($this->isFilled()) {
            $this->clear();
        }
        $this->begin();
    
    }


    /**
     * test for fixture fulfillment
     * @return boolean 
     */
    public function isFilled()
    {
        $fixture = $this->getFixture();
        return $fixture->getTimeFulfilled();
    }


    /**
     * begin the fulfill process
     * always a blank slate
     * @return null
     */
    public function begin()
    {
        
        // fixture
        $fixture = $this->getFixture();

        // teams
        $modelTeam = new model_tennis_team($this);
        $modelTeam->read(array(
            'where' => array('id' => array(
                $fixture->getTeamIdLeft(),
                $fixture->getTeamIdRight()
            ))
        ));

        // players
        $modelPlayer = new model_tennis_player($this);
        $modelPlayer->read(array(
            'where' => array('id' => array_merge($_REQUEST['player']['left'], $_REQUEST['player']['right']))
        ));
        $modelPlayer->keyByProperty('id');
        $this->setPlayers($modelPlayer->getData());

        // encouters loop
        $this->encounters();
    }


    public function encounters()
    {
        $modelFixture = new model_tennis_fixture($this);
        foreach ($modelFixture->getEncounterStructure() as $row => $positions) {
            $input = $_REQUEST['encounter'][$row];
            $rankChanges = $this->getPlayerRankChanges();
            $config = (object) array(
                'row' => $row,
                'positions' => $positions,
                'status' => $this->getInputStatus($input),
                'scoreLeft' => $input['left'],
                'scoreRight' => $input['right']
            );
            $this->encounter($config);
        }
    }


    public function encounter($config)
    {
        $fixture = $this->getFixture();
        $modelEncounter = new model_tennis_encounter($this);
        $moldEncounter = new mold_tennis_encounter();
        $moldEncounter->setfixtureId($fixture->getId());
        $moldEncounter->setScoreLeft($config->scoreLeft);
        $moldEncounter->setScoreRight($config->scoreRight);
        $moldEncounter->setPlayerIdLeft($_REQUEST['player']['left'][reset($config->positions)]);
        $moldEncounter->setPlayerIdRight($_REQUEST['player']['right'][end($config->positions)]);
        $moldEncounter->setPlayerRankChangeLeft();
        $moldEncounter->setPlayerRankChangeRight();
        $moldEncounter->setStatus($config->status);
        $modelEncounter->create($moldEncounter);
    }


    public function getInputStatus($array)
    {
        if (array_key_exists('status', $array)) {
            return $array['status'];
        }
        return '';
    }


    /**
     * revert existing filled fixture
     * @return null 
     */
    public function clear()
    {
        
    }


    /**
     * retrieve fixture and store
     * @return bool  
     */
    public function readFixture()
    {
        $modelFixture = new model_tennis_fixture($this);
        $modelFixture->read(array(
            'where' => array(
                'id' => $_REQUEST['fixture_id']
            )
        ));
        if (! $data = $modelFixture->getDataFirst()) {
            $this->session->set('feedback', 'This fixture does not exist');
            return;
        }
        return $this->setFixture($data);
    }


    /**
     * @return object mold_fixture
     */
    public function getFixture() {
        return $this->fixture;
    }
    
    
    /**
     * @param object $fixture Mold_fixture
     */
    public function setFixture($fixture) {
        $this->fixture = $fixture;
        return $this;
    }


    /**
     * ensure correct data is present, otherwise return to single with
     * error msg
     * @return bool
     */
	public function validate()
	{
		$required = array(
			'division_id',
			'team',
			'player',
			'encounter'
		);
		if (! $this->arrayKeyExists($required, $_REQUEST)) {
			$this->session->set('feedback', 'Please fill all required fields');
			return false;
		}
		return true;
	}


    /**
     * @return array 
     */
    public function getPlayers() {
        return $this->players;
    }
    
    
    /**
     * @param array $players 
     */
    public function setPlayers($players) {
        $this->players = $players;
        return $this;
    }


    public function getPlayerRankChanges($config)
    {
        // $rankLeft, $rankRight, $winner

        // work out rank difference
        $difference = $config->left > $config->right ? $config->left - $config->right : $config->right - $config->left;

        // blank change recorded
        $change = (object) array(
            'left' => 0,
            'right' => 0
        );

        // find out changes
        if ($difference <= 24) {
            if ($rankLeft > $rankRight) {
                if ($winner == true) {
                    $change->left += 12; // expected
                    $change->right -= 8; // expected
                } else {
                    $change->right += 12; // unexpected
                    $change->left -= 8; // unexpected
                }
            } else {
                if ($winner == false) {
                    $change->right += 12; // expected
                    $change->left -= 8; // expected
                } else {
                    $change->left += 12; // unexpected
                    $change->right -= 8; // unexpected
                }
            }
        } elseif ($difference <= 49) {
            if ($rankLeft > $rankRight) {
                if ($winner == true) {
                    $change->left += 11; // expected
                    $change->right -= 7; // expected
                } else {
                    $change->right += 14; // unexpected
                    $change->left -= 9; // unexpected
                }
            } else {
                if ($winner == false) {
                    $change->right += 11; // expected
                    $change->left -= 7; // expected
                } else {
                    $change->left += 14; // unexpected
                    $change->right -= 9; // unexpected
                }
            }
        } elseif ($difference <= 99) {
            if ($rankLeft > $rankRight) {
                if ($winner == true) {
                    $change->left += 9; // expected
                    $change->right -= 6; // expected
                } else {
                    $change->right += 17; // unexpected
                    $change->left -= 11; // unexpected
                }
            } else {
                if ($winner == false) {
                    $change->right += 9; // expected
                    $change->left -= 6; // expected
                } else {
                    $change->left += 17; // unexpected
                    $change->right -= 11; // unexpected
                }
            }
        } elseif ($difference <= 149) {
            if ($rankLeft > $rankRight) {
                if ($winner == true) {
                    $change->left += 8; // expected
                    $change->right -= 5; // expected
                } else {
                    $change->right += 21; // unexpected
                    $change->left -= 14; // unexpected
                }
            } else {
                if ($winner == false) {
                    $change->right += 8; // expected
                    $change->left -= 5; // expected
                } else {
                    $change->left += 21; // unexpected
                    $change->right -= 14; // unexpected
                }
            }
        } elseif ($difference <= 199) {
            if ($rankLeft > $rankRight) {
                if ($winner == true) {
                    $change->left += 6; // expected
                    $change->right -= 4; // expected
                } else {
                    $change->right += 26; // unexpected
                    $change->left -= 17; // unexpected
                }
            } else {
                if ($winner == false) {
                    $change->right += 6; // expected
                    $change->left -= 4; // expected
                } else {
                    $change->left += 26; // unexpected
                    $change->right -= 17; // unexpected
                }
            }
        } elseif ($difference <= 299) {
            if ($rankLeft > $rankRight) {
                if ($winner == true) {
                    $change->left += 5; // expected
                    $change->right -= 3; // expected
                } else {
                    $change->right += 33; // unexpected
                    $change->left -= 22; // unexpected
                }
            } else {
                if ($winner == false) {
                    $change->right += 5; // expected
                    $change->left -= 3; // expected
                } else {
                    $change->left += 33; // unexpected
                    $change->right -= 22; // unexpected
                }
            }
        } elseif ($difference <= 399) {
            if ($rankLeft > $rankRight) {
                if ($winner == true) {
                    $change->left += 3; // expected
                    $change->right -= 2; // expected
                } else {
                    $change->right += 45; // unexpected
                    $change->left -= 30; // unexpected
                }
            } else {
                if ($winner == false) {
                    $change->right += 3; // expected
                    $change->left -= 2; // expected
                } else {
                    $change->left += 45; // unexpected
                    $change->right -= 30; // unexpected
                }
            }
        } elseif ($difference <= 499) {
            if ($rankLeft > $rankRight) {
                if ($winner == true) {
                    $change->left += 2; // expected
                    $change->right -= 1; // expected
                } else {
                    $change->right += 60; // unexpected
                    $change->left -= 40; // unexpected
                }
            } else {
                if ($winner == false) {
                    $change->right += 2; // expected
                    $change->left -= 1; // expected
                } else {
                    $change->left += 60; // unexpected
                    $change->right -= 40; // unexpected
                }
            }
        } elseif ($difference >= 500) {
            if ($rankLeft > $rankRight) {
                if ($winner == true) {
                    //$change->left += 0; // expected
                    //$change->right -= 0; // expected
                } else {
                    $change->right += 75; // unexpected
                    $change->left -= 50; // unexpected
                }
            } else {
                if ($winner == false) {
                    //$change->right += 0; // expected
                    //$change->left -= 0; // expected
                } else {
                    $change->left += 75; // unexpected
                    $change->right -= 50; // unexpected
                }
            }
        }
        return $change;
    }
} 

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

