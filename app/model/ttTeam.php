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

	static $weekDays = array(
		1 => 'Monday'
		, 2 => 'Tuesday'
		, 3 => 'Wednesday'
		, 4 => 'Thursday'
		, 5 => 'Friday'
		, 6 => 'Saturday'
		, 7 => 'Sunday'
	);


	public function create() {	

		// validation

		if (! $this->validatePost($_POST, array(
			'name'
		))) {

			$this->getObject('mainUser')->setFeedback('All required fields must be filled');

			return false;
			
		}
		
		// prepare

		$sth = $this->database->dbh->prepare("
			INSERT INTO
				tt_team
				(name, home_night, venue_id, division_id)
			VALUES
				(:name, :home_night, :venue_id, :division_id)
		");				
		
		$sth->execute(array(
			':name' => $_POST['name']
			, ':home_night' => $_POST['home_night']
			, ':venue_id' => $_POST['venue_id']
			, ':division_id' => $_POST['division_id']
		));		

		// return

		if ($sth->rowCount()) {

			$this->getObject('mainUser')->setFeedback('Success! Team ' . $_POST['name'] . ' has been created');

			return true;
			
		} else {

			$this->getObject('mainUser')->setFeedback('Error Detected, Team has not been Created');

			return false;

		}
		
	}

	
	public function getWeekDays() {

		return self::$weekDays;

	}


	public function deleteById($id)
	{	
	
		// are you tied to any fixtures?

		$sth = $this->database->dbh->query("	
			select
				tt_encounter.id
			from
				tt_team
			left join tt_fixture on tt_fixture.team_left_id = tt_team.id or tt_fixture.team_right_id = tt_team.id
			where tt_team.id = '$id'
			group by tt_team.id
		");

		if ($sth->rowCount() == 1) {

			var_dump($sth->rowCount());
			exit();

			$this->getObject('mainUser')->setFeedback('Unable to delete player, they are involved with matches');

			return false;
			
		}

		// sql baseplate

		$sql = "	
			DELETE FROM
				tt_player
			WHERE tt_player.id
		";

		// handle possible array

		if (is_array($id)) {

			$sql .= " IN ( ";

			foreach ($id as $key) {

				$sql .= " '$id',";

			}

			// trim away last ','

			$sql = substr($sql, 0, -1);
			$sql .= ")";

		} else {

			$sql .= " = '$id' ";

		}

		// query database and get rows into $this->data

		$sth = $this->database->dbh->query($sql);

		// feedback & return

		if ($sth->rowCount()) {

			$this->getObject('mainUser')->setFeedback('Player Deleted Successfully');

		} else {

			$this->getObject('mainUser')->setFeedback('Error occurred, player not deleted');

		}

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

	
	public function read()
	{	
	
		$sth = $this->database->dbh->query("	
			select
				tt_team.id
				, tt_team.name
				, tt_team.home_night
				, count(tt_player.id) as player_count
				, tt_venue.name as venue_name
				, tt_division.name as division_name
			from
				tt_team
			left join tt_player on tt_player.team_id = tt_team.id
			left join tt_division on tt_team.division_id = tt_division.id
			left join tt_venue on tt_team.venue_id = tt_venue.id
			group by tt_team.id
			order by
				tt_division.id
				, tt_team.name
		");

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
			if (array_key_exists('home_night', $row))
				$row['home_night'] = self::$weekDays[$row['home_night']];

			$this->data[] = $row;
		
		}

		return $this;

	}	
	

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