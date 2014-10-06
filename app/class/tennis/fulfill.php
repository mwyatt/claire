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


    /**
     * @var object
     */
    public $fixture;


    /**
     * @var array
     */
    public $players;


    /**
     * prints r and echos message if debugging mode on
     * @param  string|array $message 
     * @return null          
     */
    public function outputDebugBlock($message)
    {       
        if ($this->isDebug($this)) {
            echo '<pre>';
            if (is_array($message) || is_object($message)) {
                print_r($message);
            } elseif (is_string($message)) {
                echo $message;
            }
            echo '</pre>';
            echo '<hr>';
        }
    }


    /**
     * validate and determine whether to clear first
     */
    public function run()
    {
        $sessionFeedback = new session_feedback($this);
        $this->outputDebugBlock('running fixture fulfillment procedure');    
        if (! $this->validate()) {
            $sessionFeedback->set('something is wrong with the input');
            return;
        }
        if (! $this->readFixture()) {
            $sessionFeedback->set('fixture does not exist');
            return;
        }
        if ($this->isFilled()) {
            $this->clear();
        }

        // if delete is flagged, dont refulfill
        if ($this->isDelete()) {
            $sessionFeedback->set('fixture deleted');
            $this->route('current');
        }

        // fulfill the fixture
        // encouters loop
        $this->encounters();

        // debug
        $this->outputDebugBlock('finished fixture fulfillment procedure');
    }


    public function isDelete()
    {
        if (! empty($_REQUEST['delete'])) {
            return true;
        }
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
     * retrieve passed player ids for players
     * players stored in player property
     * @param  array $playerIds 
     * @return null            
     */
    public function readPlayersById($playerIds)
    {
        $modelPlayer = new model_tennis_player($this);
        $modelPlayer->read(array(
            'where' => array('id' => $playerIds)
        ));
        $modelPlayer
            ->orderByPropertyIntAsc('rank')
            ->keyByProperty('id');
        $this->setPlayers($modelPlayer->getData());
    }


    /**
     * goes through encounter structure and stores each row
     * taking into account the exclusion and rank changes for players
     * @return null 
     */
    public function encounters()
    {

        // load player resource
        $this->readPlayersById(array_merge($_REQUEST['player']['left'], $_REQUEST['player']['right']));
        $this->outputDebugBlock($this->getPlayers());

        // resource
        $modelFixture = new model_tennis_fixture($this);
        $fixture = $this->getFixture();
        $players = $this->getPlayers();
        $modelEncounter = new model_tennis_encounter($this);

        // encounter structure
        foreach ($modelFixture->getEncounterStructure() as $structureRow => $playerPositions) {

            // resource
            $moldEncounter = new mold_tennis_encounter();

            // for easy access
            $inputEncounter = $_REQUEST['encounter'][$structureRow];
            $inputPlayerIdLeft = 0;
            $inputPlayerIdRight = 0;
            if (reset($playerPositions) != 'doubles') {
                $inputPlayerIdLeft = $_REQUEST['player']['left'][reset($playerPositions)];
                $inputPlayerIdRight = $_REQUEST['player']['right'][end($playerPositions)];
            }

            // build mold
            $moldEncounter->setfixtureId($fixture->getId());
            $moldEncounter->setScoreLeft($inputEncounter['left']);
            $moldEncounter->setScoreRight($inputEncounter['right']);
            $moldEncounter->setPlayerIdLeft($inputPlayerIdLeft);
            $moldEncounter->setPlayerIdRight($inputPlayerIdRight);
            $moldEncounter->setStatus($this->getInputStatus($inputEncounter));

            // obtain rank changes for the two players
            $config = (object) array(
                'idLeft' => $moldEncounter->getPlayerIdLeft(),
                'idRight' => $moldEncounter->getPlayerIdRight(),
                'scoreLeft' => $moldEncounter->getScoreLeft(),
                'scoreRight' => $moldEncounter->getScoreRight(),
                'status' => $moldEncounter->getStatus()
            );
            $rankChanges = $this->calculatePlayerRankChanges($config);

            // set rank changes and store mold            
            $moldEncounter->setPlayerRankChangeLeft($rankChanges->left);
            $moldEncounter->setPlayerRankChangeRight($rankChanges->right);
            $this->outputDebugBlock($moldEncounter);

            // store encounters
            if (! $this->isDebug($this)) {
                $modelEncounter->create(array($moldEncounter));
            }
        }


        // remaining operations
        $this->finalise();
    }


    /**
     * final fulfill operations such as flagging the fixture as filled and
     * committing the player rank changes
     * @return null 
     */
    public function finalise()
    {

        // resource
        $modelFixture = new model_tennis_fixture($this);
        $sessionFeedback = new session_feedback($this);
        $fixture = $this->getFixture();

        // update player ranks
        $this->updatePlayerRanks();

        // update fixture fulfill time
        $fixture->setTimeFulfilled(time());
        $this->outputDebugBlock($fixture);
        if (! $this->isDebug($this)) {
            $modelFixture->update($fixture, array(
                'where' => array(
                    'id' => $fixture->getId()
                )
            ));
        }
        $sessionFeedback->set('fixture fulfilled sucessfully');
        $this->route('current', 'fixture_id=' . $fixture->getId());
    }


    /**
     * iterates through all stored players and updates them
     * @return null 
     */
    public function updatePlayerRanks()
    {
        $this->outputDebugBlock('player ranks would be updated here');
        $this->outputDebugBlock($this->getPlayers());
        if ($this->isDebug($this)) {
            return;
        }
        $modelPlayer = new model_tennis_Player($this);
        foreach ($this->getPlayers() as $playerId => $player) {
            $modelPlayer->update($player, array(
                'where' => array(
                    'id' => $playerId
                )
            ));
        }
    }


    /**
     * gets the status value from an input array
     * @param  array $inputEncounter 
     * @return string                 
     */
    public function getInputStatus($inputEncounter)
    {
        if (array_key_exists('status', $inputEncounter)) {
            return $inputEncounter['status'];
        }
        return '';
    }


    /**
     * revert existing filled fixture
     * @return null 
     */
    public function clear()
    {
        $this->outputDebugBlock('clearing existing fixture...');

        // fixture
        $fixture = $this->getFixture();
        
        // encounter
        $modelEncounter = new model_tennis_encounter($this);
        $modelEncounter->read(array(
            'where' => array('fixture_id' => $fixture->getId())
        ));
        $this->readPlayersById(array_merge($modelEncounter->getDataProperty('player_id_left'), $modelEncounter->getDataProperty('player_id_right')));
        $players = $this->getPlayers();

        // make rank changes
        foreach ($modelEncounter->getData() as $encounter) {
            if (array_key_exists($encounter->getPlayerIdLeft(), $players)) {
                $players[$encounter->getPlayerIdLeft()]->modifyRank($encounter->getPlayerRankChangeLeft(), true);
            }
            if (array_key_exists($encounter->getPlayerIdRight(), $players)) {
                $players[$encounter->getPlayerIdRight()]->modifyRank($encounter->getPlayerRankChangeRight(), true);
            }
        }

        // set players and update player ranks
        $this->setPlayers($players);
        $this->updatePlayerRanks();

        // delete encounters
        $modelEncounter->delete(array(
            'where' => array('fixture_id' => $fixture->getId())
        ));

        // clear fixture date
        $modelFixture = new model_tennis_fixture($this);
        $fixture->setTimeFulfilled(0);
        $modelFixture->update($fixture, array(
            'where' => array(
                'id' => $fixture->getId()
            )
        ));
        $this->outputDebugBlock('existing fixture cleared');
    }


    /**
     * retrieve fixture by looking at the teams selected
     * @return bool  
     */
    public function readFixture()
    {
        
        // teams
        $modelTeam = new model_tennis_team($this);
        $modelTeam->read(array(
            'where' => array('id' => array(
                $_REQUEST['team']['left'],
                $_REQUEST['team']['right']
            ))
        ));
        if (count($modelTeam->getData()) != 2) {
            return;
        }
        $modelTeam->keyByProperty('id');
        $teamLeft = $modelTeam->getData($_REQUEST['team']['left']);
        $teamRight = $modelTeam->getData($_REQUEST['team']['right']);
        
        // find fixture based on teams
        $modelFixture = new model_tennis_fixture($this);
        $modelFixture->read(array(
            'where' => array(
                'team_id_left' => $teamLeft->getId(),
                'team_id_right' => $teamRight->getId()
            )
        ));
        $this->outputDebugBlock($modelFixture->getData());
        if (! $data = $modelFixture->getDataFirst()) {
            // $this->session->set('feedback', 'This fixture does not exist');
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


    /**
     * need
     * idLeft
     * idRight
     * scoreLeft
     * scoreRight
     * status
     * player scores
     * @param  [type] $config [description]
     * @return [type]         [description]
     */
    public function calculatePlayerRankChanges($config)
    {

        // record changes
        $changes = (object) array(
            'left' => 0,
            'right' => 0
        );

        // status filled means dont change
        if ($config->status) {
            return $changes;
        }

        // a player missing from one side means dont change
        if (! $config->idLeft || ! $config->idRight) {
            return $changes;
        }

        // resource
        $players = $this->getPlayers();
        $playerLeft = $players[$config->idLeft];
        $playerRight = $players[$config->idRight];
        $rankLeft = $playerLeft->getRank();
        $rankRight = $playerRight->getRank();

        // find rank difference
        $difference = $rankLeft > $rankRight ? $rankLeft - $rankRight : $rankRight - $rankLeft;

        // find winner
        $winner = 'right';
        if ($config->scoreLeft > $config->scoreRight) {
            $winner = 'left';
        }

        // find out changes
        if ($difference <= 24) {
            if ($rankLeft > $rankRight) {
                if ($winner == 'left') {
                    $changes->left += 12; // expected
                    $changes->right -= 8; // expected
                } else {
                    $changes->right += 12; // unexpected
                    $changes->left -= 8; // unexpected
                }
            } else {
                if ($winner == 'right') {
                    $changes->right += 12; // expected
                    $changes->left -= 8; // expected
                } else {
                    $changes->left += 12; // unexpected
                    $changes->right -= 8; // unexpected
                }
            }
        } elseif ($difference <= 49) {
            if ($rankLeft > $rankRight) {
                if ($winner == 'left') {
                    $changes->left += 11; // expected
                    $changes->right -= 7; // expected
                } else {
                    $changes->right += 14; // unexpected
                    $changes->left -= 9; // unexpected
                }
            } else {
                if ($winner == 'right') {
                    $changes->right += 11; // expected
                    $changes->left -= 7; // expected
                } else {
                    $changes->left += 14; // unexpected
                    $changes->right -= 9; // unexpected
                }
            }
        } elseif ($difference <= 99) {
            if ($rankLeft > $rankRight) {
                if ($winner == 'left') {
                    $changes->left += 9; // expected
                    $changes->right -= 6; // expected
                } else {
                    $changes->right += 17; // unexpected
                    $changes->left -= 11; // unexpected
                }
            } else {
                if ($winner == 'right') {
                    $changes->right += 9; // expected
                    $changes->left -= 6; // expected
                } else {
                    $changes->left += 17; // unexpected
                    $changes->right -= 11; // unexpected
                }
            }
        } elseif ($difference <= 149) {
            if ($rankLeft > $rankRight) {
                if ($winner == 'left') {
                    $changes->left += 8; // expected
                    $changes->right -= 5; // expected
                } else {
                    $changes->right += 21; // unexpected
                    $changes->left -= 14; // unexpected
                }
            } else {
                if ($winner == 'right') {
                    $changes->right += 8; // expected
                    $changes->left -= 5; // expected
                } else {
                    $changes->left += 21; // unexpected
                    $changes->right -= 14; // unexpected
                }
            }
        } elseif ($difference <= 199) {
            if ($rankLeft > $rankRight) {
                if ($winner == 'left') {
                    $changes->left += 6; // expected
                    $changes->right -= 4; // expected
                } else {
                    $changes->right += 26; // unexpected
                    $changes->left -= 17; // unexpected
                }
            } else {
                if ($winner == 'right') {
                    $changes->right += 6; // expected
                    $changes->left -= 4; // expected
                } else {
                    $changes->left += 26; // unexpected
                    $changes->right -= 17; // unexpected
                }
            }
        } elseif ($difference <= 299) {
            if ($rankLeft > $rankRight) {
                if ($winner == 'left') {
                    $changes->left += 5; // expected
                    $changes->right -= 3; // expected
                } else {
                    $changes->right += 33; // unexpected
                    $changes->left -= 22; // unexpected
                }
            } else {
                if ($winner == 'right') {
                    $changes->right += 5; // expected
                    $changes->left -= 3; // expected
                } else {
                    $changes->left += 33; // unexpected
                    $changes->right -= 22; // unexpected
                }
            }
        } elseif ($difference <= 399) {
            if ($rankLeft > $rankRight) {
                if ($winner == 'left') {
                    $changes->left += 3; // expected
                    $changes->right -= 2; // expected
                } else {
                    $changes->right += 45; // unexpected
                    $changes->left -= 30; // unexpected
                }
            } else {
                if ($winner == 'right') {
                    $changes->right += 3; // expected
                    $changes->left -= 2; // expected
                } else {
                    $changes->left += 45; // unexpected
                    $changes->right -= 30; // unexpected
                }
            }
        } elseif ($difference <= 499) {
            if ($rankLeft > $rankRight) {
                if ($winner == 'left') {
                    $changes->left += 2; // expected
                    $changes->right -= 1; // expected
                } else {
                    $changes->right += 60; // unexpected
                    $changes->left -= 40; // unexpected
                }
            } else {
                if ($winner == 'right') {
                    $changes->right += 2; // expected
                    $changes->left -= 1; // expected
                } else {
                    $changes->left += 60; // unexpected
                    $changes->right -= 40; // unexpected
                }
            }
        } elseif ($difference >= 500) {
            if ($rankLeft > $rankRight) {
                if ($winner == 'left') {
                    //$changes->left += 0; // expected
                    //$changes->right -= 0; // expected
                } else {
                    $changes->right += 75; // unexpected
                    $changes->left -= 50; // unexpected
                }
            } else {
                if ($winner == 'right') {
                    //$changes->right += 0; // expected
                    //$changes->left -= 0; // expected
                } else {
                    $changes->left += 75; // unexpected
                    $changes->right -= 50; // unexpected
                }
            }
        }

        // update player rank based on this encounter
        $players[$config->idLeft]->modifyRank($changes->left);
        $players[$config->idRight]->modifyRank($changes->right);
        $this->outputDebugBlock(array(
            'previous ' . $rankLeft,
            'modifier ' . $changes->left,
            'next ' . ($rankLeft + $changes->left)
        ));

        // object of changes
        return $changes;
    }
}
