<?php

/**
 * ttVenue
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Model_Ttencounterpart extends Model
{		

	public function readChange($playerId = false)
	{	

		$sql = "select sum(tt_encounter_part.player_rank_change) as player_rank_change from tt_encounter_part where tt_encounter_part.status = '' ";

		if ($playerId) {
			$sql .= " and tt_encounter_part.player_id = :playerId ";
			$sth = $this->database->dbh->prepare($sql);
			$sth->execute(array(
				':playerId' => $playerId
			));	
		} else {
			$sth = $this->database->dbh->query($sql);
		}

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
			$this->data[] = $row;
		}

	}	

	public function read($playerId = false, $limit = false)
	{	

		$sql = "select tt_encounter_part.player_rank_change from tt_encounter_part";

		if ($playerId) {
			$sql .= " where tt_encounter_part.player_id = :playerId ";
			$execution[':playerId'] = $playerId;
		}

		if ($limit) {
			$sql .= " limit $limit ";
		}

		$sth = $this->database->dbh->prepare($sql);
		$sth->execute($execution);	

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
			$this->data[] = $row;
		}

	}	

	public function readPerformance($playerId = false)
	{	

		$sth = $this->database->dbh->query("
			select
				tt_player.id as player_id
				, sum(tt_encounter_part.player_rank_change) as player_rank_change
				, concat(tt_player.first_name, ' ', tt_player.last_name) as player_name
				, tt_team.id as team_id
				, tt_team.name as team_name
			from tt_encounter_part
			left join tt_player on tt_player.id = tt_encounter_part.player_id
			left join tt_team on tt_team.id = tt_player.team_id
			where tt_encounter_part.status = ''
			group by tt_player.id
			order by player_rank_change desc
		");

		// if ($playerId) {
		// 	$sql .= " where tt_encounter_part.player_id = :playerId ";
		// 	$execution[':playerId'] = $playerId;
		// }
		
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
			$row['player_guid'] = $this->getGuid('player', $row['player_name'], $row['player_id']);
			$row['team_guid'] = $this->getGuid('team', $row['team_name'], $row['team_id']);
			$this->data[] = $row;
		}

	}	

}