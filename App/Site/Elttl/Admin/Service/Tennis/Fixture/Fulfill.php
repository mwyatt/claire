<?php
namespace OriginalAppName\Site\Elttl\Admin\Service\Tennis\Fixture;


class Fulfill extends \OriginalAppName\Site\Elttl\Model\Tennis
{


    /**
     * \OriginalAppName\Controller
     * @var object
     */
    private $controller;


    /**
     * @var object
     */
    private $fixture;


    /**
     * @var array
     */
    private $players;


    /**
     * sort out controller for redirect
     */
    public function __construct()
    {
        parent::__construct();
        $this->controller = new \OriginalAppName\Controller;
    }


    /**
     * debug mode is set
     * @return boolean true if debug on
     */
    public function isDebug($compat = null)
    {
        return isset($_REQUEST['debug']);
    }


    /**
     * prints r and echos message if debugging mode on
     * @param  string|array $message 
     * @return null          
     */
    private function outputDebugBlock($message)
    {       
        if ($this->isDebug()) {
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
    public function boot()
    {
        $sessionFeedback = new \OriginalAppName\Session\Feedback;
        $this->outputDebugBlock('running fixture fulfillment procedure');    
        if (!$this->validate()) {
            $sessionFeedback->setMessage('something is wrong with the input', 'negative');
            return;
        }
        if (!$this->readFixture()) {
            $sessionFeedback->setMessage('fixture does not exist', 'negative');
            return;
        }
        if ($this->isFilled()) {
            $this->clear();
        }

        // if delete is flagged, dont refulfill
        if ($this->isDelete()) {
            $sessionFeedback->setMessage('fixture deleted', 'positive');
            $this->controller->redirect('admin/tennis/fixture/all');
        }

        // fulfill the fixture
        // encouters loop
        $this->encounters();

        // debug
        $this->outputDebugBlock('finished fixture fulfillment procedure');
    }


    private function isDelete()
    {
        if (!empty($_REQUEST['delete'])) {
            return true;
        }
    }


    /**
     * test for fixture fulfillment
     * @return boolean 
     */
    private function isFilled()
    {
        $fixture = $this->getFixture();
        return $fixture->timeFulfilled;
    }


    /**
     * retrieve passed player ids for players
     * players stored in player property
     * @param  array $playerIds 
     * @return null            
     */
    private function readPlayersById($playerIds)
    {
        $modelPlayer = new \OriginalAppName\Site\Elttl\Model\Tennis\Player;
        $modelPlayer
            ->readYearId(null, $playerIds)
            ->orderByProperty('rank')
            ->keyDataByProperty('id');
        $this->setPlayers($modelPlayer->getData());
    }


    /**
     * goes through encounter structure and stores each row
     * taking into account the exclusion and rank changes for players
     * @return null 
     */
    private function encounters()
    {

        // load player resource
        $this->readPlayersById(array_merge($_REQUEST['player']['left'], $_REQUEST['player']['right']));
        $this->outputDebugBlock($this->getPlayers());

        // resource
        $modelFixture = new \OriginalAppName\Site\Elttl\Model\Tennis\Fixture;
        $fixture = $this->getFixture();
        $players = $this->getPlayers();
        $modelEncounter = new \OriginalAppName\Site\Elttl\Model\Tennis\Encounter;

        // encounter structure
        foreach ($modelFixture->getEncounterStructure() as $structureRow => $playerPositions) {

            // resource
            $moldEncounter = new \OriginalAppName\Site\Elttl\Entity\Tennis\Encounter;

            // for easy access
            $inputEncounter = $_REQUEST['encounter'][$structureRow];
            $inputPlayerIdLeft = 0;
            $inputPlayerIdRight = 0;
            if (reset($playerPositions) != 'doubles') {
                $inputPlayerIdLeft = $_REQUEST['player']['left'][reset($playerPositions)];
                $inputPlayerIdRight = $_REQUEST['player']['right'][end($playerPositions)];
            }

            // build mold
            $moldEncounter->yearId = $this->yearId;
            $moldEncounter->fixtureId = $fixture->id;
            $moldEncounter->scoreLeft = $inputEncounter['left'];
            $moldEncounter->scoreRight = $inputEncounter['right'];
            $moldEncounter->playerIdLeft = $inputPlayerIdLeft;
            $moldEncounter->playerIdRight = $inputPlayerIdRight;
            $moldEncounter->status = $this->getInputStatus($inputEncounter);

            // obtain rank changes for the two players
            $config = (object) [
                'idLeft' => $moldEncounter->playerIdLeft,
                'idRight' => $moldEncounter->playerIdRight,
                'scoreLeft' => $moldEncounter->scoreLeft,
                'scoreRight' => $moldEncounter->scoreRight,
                'status' => $moldEncounter->status
            ];
            $rankChanges = $this->calculatePlayerRankChanges($config);

            // set rank changes and store mold            
            $moldEncounter->playerRankChangeLeft = $rankChanges->left;
            $moldEncounter->playerRankChangeRight = $rankChanges->right;
            $this->outputDebugBlock($moldEncounter);

            // store encounters
            if (!$this->isDebug()) {
                $modelEncounter->create([$moldEncounter]);
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
    private function finalise()
    {

        // resource
        $modelFixture = new \OriginalAppName\Site\Elttl\Model\Tennis\Fixture;
        $sessionFeedback = new \OriginalAppName\Session\Feedback;
        $fixture = $this->getFixture();

        // update player ranks
        $this->updatePlayerRanks();

        // update fixture fulfill time
        $fixture->timeFulfilled = time();
        $this->outputDebugBlock($fixture);
        if (!$this->isDebug()) {
            $modelFixture->updateYear(null, [$fixture]);
        }
        $sessionFeedback->setMessage('fixture fulfilled sucessfully', 'positive');
        $this->controller->redirect('admin/tennis/fixture/single', ['id' => $fixture->id]);
    }


    /**
     * iterates through all stored players and updates them
     * @return null 
     */
    private function updatePlayerRanks()
    {
        $this->outputDebugBlock('player ranks would be updated here');
        $this->outputDebugBlock($this->getPlayers());
        if ($this->isDebug()) {
            return;
        }
        $modelPlayer = new \OriginalAppName\Site\Elttl\Model\Tennis\Player;
        foreach ($this->getPlayers() as $playerId => $player) {
            $modelPlayer->updateYear(null, [$player]);
        }
    }


    /**
     * gets the status value from an input array
     * @param  array $inputEncounter 
     * @return string                 
     */
    private function getInputStatus($inputEncounter)
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
    private function clear()
    {
        $this->outputDebugBlock('clearing existing fixture...');
        $modelFixture = new \OriginalAppName\Site\Elttl\Model\Tennis\Fixture;

        // fixture reset time
        $fixture = $this->getFixture();
        $fixture->timeFulfilled = null;
        $modelFixture->updateYear(null, [$fixture]);
        
        // encounter
        $modelEncounter = new \OriginalAppName\Site\Elttl\Model\Tennis\Encounter;
        $modelEncounter->readYearId(null, [$fixture->id]);
        
        // no encounters means fixture with date fulfilled only
        if (!$modelEncounter->getData()) {
            return;
        }
        
        // get players
        $this->readPlayersById(array_merge($modelEncounter->getDataProperty('playerIdLeft'), $modelEncounter->getDataProperty('playerIdRight')));
        $players = $this->getPlayers();

        // make rank changes
        foreach ($modelEncounter->getData() as $encounter) {
            if (array_key_exists($encounter->playerIdLeft, $players)) {
                $players[$encounter->playerIdLeft]->modifyRank($encounter->playerRankChangeLeft, true);
            }
            if (array_key_exists($encounter->playerIdRight, $players)) {
                $players[$encounter->playerIdRight]->modifyRank($encounter->playerRankChangeRight, true);
            }
        }

        // set players and update player ranks
        $this->setPlayers($players);
        $this->updatePlayerRanks();

        // delete encounters
        $modelEncounter->deleteYear(null, $modelEncounter->getDataProperty('id'));

        // clear fixture date
        $this->outputDebugBlock('existing fixture cleared');
    }


    /**
     * retrieve fixture by looking at the teams selected
     * @return bool  
     */
    private function readFixture()
    {
        
        // teams
        $modelTeam = new \OriginalAppName\Site\Elttl\Model\Tennis\Team;
        $modelTeam->readYearId(null, [$_REQUEST['team']['left'], $_REQUEST['team']['right']]);
        echo '<pre>';
        print_r($modelTeam);
        echo '</pre>';
        exit;
        
        if (count($modelTeam->getData()) != 2) {
            return;
        }
        $modelTeam->keyDataByProperty('id');
        $teamLeft = $modelTeam->getData($_REQUEST['team']['left']);
        $teamRight = $modelTeam->getData($_REQUEST['team']['right']);
        
        // find fixture based on teams
        $modelFixture = new \OriginalAppName\Site\Elttl\Model\Tennis\Fixture;
        $modelFixture->readYearColumn(null, 'teamIdLeft', $teamLeft->id);
        foreach ($modelFixture->getData() as $entityFixture) {
            if ($entityFixture->teamIdRight == $teamRight->id) {
                $fixture = $entityFixture;
            }
        }
        $this->outputDebugBlock($fixture);
        if (empty($fixture)) {
            return;
        }
        return $this->setFixture($fixture);
    }


    /**
     * @return object mold_fixture
     */
    private function getFixture() {
        return $this->fixture;
    }
    
    
    /**
     * @param object $fixture Mold_fixture
     */
    private function setFixture($fixture) {
        $this->fixture = $fixture;
        return $this;
    }


    /**
     * ensure correct data is present, otherwise return to single with
     * error msg
     * @return bool
     */
    private function validate()
    {
        $required = array(
            'division_id',
            'team',
            'player',
            'encounter'
        );
        if (!\OriginalAppName\Helper::arrayKeyExists($required, $_REQUEST)) {
            $this->session->set('feedback', 'Please fill all required fields');
            return false;
        }
        return true;
    }


    /**
     * @return array 
     */
    private function getPlayers() {
        return $this->players;
    }
    
    
    /**
     * @param array $players 
     */
    private function setPlayers($players) {
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
    private function calculatePlayerRankChanges($config)
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
        if (!$config->idLeft || !$config->idRight) {
            return $changes;
        }

        // resource
        $players = $this->getPlayers();
        $playerLeft = $players[$config->idLeft];
        $playerRight = $players[$config->idRight];
        $rankLeft = $playerLeft->rank;
        $rankRight = $playerRight->rank;

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
