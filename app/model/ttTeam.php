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
class Model_Ttteam extends Model
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


	/**
	 * update team record using post
	 * @param  array $post 
	 * @return bool        
	 */
	public function update($post) {

		// validation

		if (! $this->validatePost($post, array(
			'name'
		))) {

			$this->getObject('mainUser')->setFeedback('All required fields must be filled');

			return false;
			
		}

		$sth = $this->database->dbh->prepare("

			update
				tt_team
			set
				name = :name
				, secretary_id = :secretary_id
				, venue_id = :venue_id
				, home_night = :home_night
				, division_id = :division_id
			where
				id = :id

		");	

		$sth->execute(array(
			':name' => $post['name']
			, ':id' => $_GET['update']
			, ':secretary_id' => $post['secretary_id']
			, ':venue_id' => $post['venue_id']
			, ':home_night' => $post['home_night']
			, ':division_id' => $post['division_id']
		));		

		if ($sth->rowCount()) {

			$this->getObject('mainUser')->setFeedback('Team Successfully Updated');

			return true;
			
		}

		return false;

	}


	/**
	 * read team by id
	 * @param  int $id 
	 * @return bool     
	 */
	public function readById($id)
	{	

		$sth = $this->database->dbh->prepare("

			select
				tt_team.id
				, tt_team.name
				, tt_team.home_night
				, tt_venue.name as venue_name
				, tt_division.name as division_name

			from
				tt_team

			left join tt_division on tt_team.division_id = tt_division.id
			left join tt_venue on tt_team.venue_id = tt_venue.id
			
			where
				tt_team.id = :id

			group by
				tt_team.id

		");				
		
		$sth->execute(array(
			':id' => $id
		));

		if ($this->setDataStatement($sth))

			return true;

		else

			return false;

	}	


	public function deleteById($id)
	{	
	
		// tied to any fixtures?

		$sth = $this->database->dbh->prepare("

			select
				count(tt_fixture.id) as count

			from
				tt_team

			left join
				tt_fixture on tt_fixture.team_left_id = tt_team.id or tt_fixture.team_right_id = tt_team.id

			where
				tt_team.id = :id

			group by
				tt_team.id

		");				
		
		$sth->execute(array(
			':id' => $id
		));

		if ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
			if ($row['count']) {

				$this->getObject('mainUser')->setFeedback('Unable to delete team, fixtures have been generated');

				return false;

			}
		
		}

		// tied to any players?

		$sth = $this->database->dbh->prepare("

			select
				count(tt_player.id) as count

			from
				tt_team

			left join
				tt_player on tt_player.team_id = tt_team.id

			where
				tt_team.id = :id

			group by
				tt_team.id

		");				
		
		$sth->execute(array(
			':id' => $id
		));

		if ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
			if ($row['count']) {

				$this->getObject('mainUser')->setFeedback('Unable to delete team, players are assigned to it');

				return false;

			}
		
		}

		// delete team

		$sth = $this->database->dbh->prepare("

			delete from
				tt_team

			where
				tt_team.id = :id

		");				
		
		$sth->execute(array(
			':id' => $id
		));		

		// feedback & return

		if ($sth->rowCount()) {

			$this->getObject('mainUser')->setFeedback('Team Deleted Successfully');

		} else {

			$this->getObject('mainUser')->setFeedback('Error occurred, team not deleted');

		}

	}



	// public function selectByDivision($id)
	// {	
	
	// 	$sth = $this->database->dbh->query("	
	// 		SELECT
	// 			tt_team.id AS team_id
	// 			, tt_team.name AS team_name
	// 		FROM
	// 			tt_team
	// 		LEFT JOIN tt_division ON tt_team.division_id = tt_division.id
	// 		WHERE tt_division.id = '$id'
	// 		ORDER BY tt_team.id
	// 	");
		
	// 	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
	// 		$this->data[$row['team_id']] = $row;
	
	// 	}	

	// }	

	
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

		$view = new View($this->database, $this->config);

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
		
			if (array_key_exists('home_night', $row))
				$row['home_night'] = self::$weekDays[$row['home_night']];

			$row['guid'] = $this->getGuid($row['name'], $row['id']);

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


	public function readLeague($divisionId) {

		$sth = $this->database->dbh->prepare("	
			select
				tt_team.id
				, tt_team.name
				, sum(case when tt_fixture_result.left_id = tt_team.id and tt_fixture_result.left_score > tt_fixture_result.right_score or tt_fixture_result.right_id = tt_team.id and tt_fixture_result.right_score > tt_fixture_result.left_score then 1 else 0 end) as won
				, sum(case when tt_fixture_result.left_id = tt_team.id and tt_fixture_result.left_score = tt_fixture_result.right_score or tt_fixture_result.right_id = tt_team.id and tt_fixture_result.right_score = tt_fixture_result.left_score then 1 else 0 end) as draw
				, sum(case when tt_fixture_result.left_id = tt_team.id and tt_fixture_result.left_score < tt_fixture_result.right_score or tt_fixture_result.right_id = tt_team.id and tt_fixture_result.right_score < tt_fixture_result.left_score then 1 else 0 end) as lost
				, count(tt_fixture_result.fixture_id) as played
				, (sum(case when tt_fixture_result.left_id = tt_team.id then tt_fixture_result.left_score else 0 end) + sum(case when tt_fixture_result.right_id = tt_team.id then tt_fixture_result.right_score else 0 end)) as points

			from tt_team

			left join tt_fixture_result on tt_fixture_result.left_id = tt_team.id or tt_fixture_result.right_id = tt_team.id

			where tt_team.division_id = :division_id

			group by tt_team.id

			order by points desc
		");

		$sth->execute(array(':division_id' => $divisionId));

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {	
			$row['guid'] = $this->getGuid($row['name'], $row['id']);
			$this->data[] = $row;
		}

		return $this;

	}
		
	public function getGuid($name, $id) {
		return $this->config->getUrl('base') . 'team/' . $this->urlFriendly($name) . '-' . $id . '/';
	}

	
	

	
}