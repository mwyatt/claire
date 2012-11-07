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
	public function read()
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
	

	/**
	 * pull team data for a single division
	 * @param  int $division_id 
	 * @return object              
	 */
	public function readByDivision($division_id) {

		$sth = $this->database->dbh->query("	
			select
				t.id
				, t.name
			from tt_team as t
			where t.division_id = '$division_id'
			group by t.id
			order by t.name asc
		");

		$this->setDataStatement($sth);

		return $this;

	}


	public function readLeague() {

		$sth = $this->database->dbh->query("	
			select
				t.id
				, t.name
				, count(f.id) as played
				, count(e.id) as encounters
			from tt_team as t
			left join tt_fixture as f on f.team_left_id = t.id or f.team_right_id = t.id
			left join tt_encounter as e on e.fixture_id = f.id
			where t.division_id = '1'
			and f.date_fulfilled is not null
			group by t.id
		");

/*

			left join tt_encounter_part as ep on ep.id = e.part_left_id or ep.id = e.part_right_id


			select
				p.id
				, concat(p.first_name, ' ', p.last_name) as full_name
				, t.name as team
				, sum(case when ep2.player_id = p.id then ep2.player_score else NULL end) as won
				, sum(ep2.player_score) as played
			from tt_player as p
			left join tt_team as t on t.id = p.team_id
			left join tt_encounter_part as ep on ep.player_id = p.id
			left join tt_encounter as enc on enc.part_left_id = ep.id or enc.part_right_id = ep.id
			left join tt_encounter_part as ep2 on ep2.id = enc.part_left_id or ep2.id = enc.part_right_id
			where t.division_id = '1'
			group by p.id

 */

		$this->setDataStatement($sth);

		return $this;

	}
		
	

	
	

	
	

	
}