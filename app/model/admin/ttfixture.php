<?php

/**
 * ttFixture
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Model_Admin_Ttfixture extends Model_Ttfixture
{

	public function readById($id) {
		// $sth = $this->database->dbh->prepare("	
		// 	select
		// 		tt_fixture.id
		// 		, tt_fixture.date_fulfilled
		// 		, tt_fixture.team_left_id
		// 		, team_left.name as team_left_name
		// 		, tt_fixture.team_right_id
		// 		, team_right.name as team_right_name
		// 		, sum(encounter_part_left.player_score) as score_left
		// 		, sum(encounter_part_right.player_score) as score_right
		// 	from tt_fixture
		// 	left join tt_team as team_left on team_left.id = tt_fixture.team_left_id
		// 	left join tt_team as team_right on team_right.id = tt_fixture.team_right_id
		// 	left join tt_encounter on tt_encounter.fixture_id = tt_fixture.id
		// 	left join tt_encounter_part as encounter_part_left on encounter_part_left.id = tt_encounter.part_left_id
		// 	left join tt_encounter_part as encounter_part_right on encounter_part_right.id = tt_encounter.part_right_id
		// 	where tt_fixture.id = ? and tt_fixture.date_fulfilled is not null
		// ");
		// $sth->execute(array($id));
		// $fixture = $sth->fetch(PDO::FETCH_OBJ);
		// if (! $fixture->date_fulfilled) {
		// 	return false;
		// }
		$sth = $this->database->dbh->prepare("	
			select
				tt_fixture.id		
				, concat(player_left.first_name, ' ', player_left.last_name) as player_left_full_name
				, concat(player_right.first_name, ' ', player_right.last_name) as player_right_full_name
				, tt_encounter_result.left_id as player_left_id
				, tt_encounter_result.right_id as player_right_id
				, tt_encounter_result.left_rank_change
				, tt_encounter_result.right_rank_change
				, tt_encounter_result.left_score as player_left_score
				, tt_encounter_result.right_score as player_right_score
				, team_left.id as team_left_id
				, team_right.id as team_right_id
				, team_left.name as team_left_name
				, team_right.name as team_right_name
				, tt_fixture_result.left_score as team_left_score
				, tt_fixture_result.right_score as team_right_score
				, tt_encounter_result.status
				, tt_fixture.date_fulfilled		
			from tt_encounter_result
			left join tt_player as player_left on player_left.id = tt_encounter_result.left_id
			left join tt_player as player_right on player_right.id = tt_encounter_result.right_id
			left join tt_fixture on tt_fixture.id = tt_encounter_result.fixture_id
			left join tt_fixture_result on tt_fixture_result.fixture_id = tt_encounter_result.fixture_id
			left join tt_team as team_left on team_left.id = tt_fixture.team_left_id
			left join tt_team as team_right on team_right.id = tt_fixture.team_right_id
			where tt_encounter_result.fixture_id = ?
			group by tt_encounter_result.encounter_id
			order by tt_encounter_result.encounter_id
		");
		$sth->execute(array($id));
		if (! $sth->rowCount()) {
			return false;
		}
		$this->data = $sth->fetchAll(PDO::FETCH_ASSOC);
		return true;
	}

	
}
