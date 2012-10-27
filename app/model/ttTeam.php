<?php

/**
 * Fixture
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class ttTeam extends Model
{	
	
	public function create($_POST) {
	
	
		$sth = $this->database->dbh->prepare("
			INSERT INTO
				tt_team
				(name, home_night, venue_id, division_id)
			VALUES
				(:name, :home_night, :venue_id, :division_id)
		");				
		/*
		$sth->execute(array(
			':first_name' => $firstName
			, ':last_name' => $lastName
			, ':rank' => $rank
			, ':team_id' => $teamId
		));		*/
		
		return $sth->rowCount();
		
	}
	
	
	public function selectByDivision($id)
	{	
	
		$sth = $this->database->dbh->query("	
			SELECT
				tt_team.id AS team_id
				, tt_team.name AS team_name
			FROM
				tt_team
			LEFT JOIN tt_division ON tt_team.division_id = tt_division.id
			WHERE tt_division.id = '$id'
			ORDER BY tt_team.id
		");
		
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
			$this->data[$row['team_id']] = $row;
	
		}	

	}	

	
	/**
	 * all team information with player count
	 */
	public function select()
	{	
	
		$sth = $this->database->dbh->query("	
			SELECT
				tt_team.id AS team_id
				, tt_team.name AS team_name
				, tt_team.home_night AS team_home_night
				, tt_venue.name AS venue_name
				, tt_division.name AS division_name
			FROM
				tt_team
			LEFT JOIN tt_player ON tt_player.team_id = tt_team.id
			LEFT JOIN tt_division ON tt_team.division_id = tt_division.id
			LEFT JOIN tt_venue ON tt_team.venue_id = tt_venue.id
			ORDER BY
				tt_division.id
				, tt_team.id
				, tt_player.rank DESC
		");
		
		// while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
		// 	$this->data[$row['team_id']] = array(
		// 		'team_id' => $row['team_id']
		// 		, 'team_name' => $row['team_name']
		// 		, 'team_rank' => $row['team_rank']
		// 		, 'team_name' => $row['team_name']
		// 		, 'division_name' => $row['division_name']
		// 	);
	
		//}	

	}	
	

	/* Update
	======================================================================== */
	
	/* Delete
	======================================================================== */

	/**
	 *
	 */
	public function delete($id)
	{	
	
		$sth = $this->database->dbh->query("
			DELETE FROM
				tt_team
			WHERE
				id = '$id'		
		");
		
		return $sth->rowCount();
		
	}
	
	
		
	

	
	

	
	

	
}