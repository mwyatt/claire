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
class Model_Ttencounter_Result extends Model
{

	public function readByFixtureId($id) {
		$sth = $this->database->dbh->prepare("
			select
				tt_encounter_result.encounter_id
				, tt_encounter_result.tt_encounter_part_left_id
				, tt_encounter_result.tt_encounter_part_right_id
				, tt_encounter_result.left_id
				, tt_encounter_result.right_id
				, tt_encounter_result.left_score
				, tt_encounter_result.right_score
				, tt_encounter_result.left_rank_change
				, tt_encounter_result.right_rank_change
				, tt_encounter_result.fixture_id
				, tt_encounter_result.status
			from tt_encounter_result
			where fixture_id = ?
		");				
		$sth->execute(array($id));	
		if ($sth->rowCount()) {
			return $this->data = $sth->fetchAll(PDO::FETCH_ASSOC);
		} 
		return false;
	}

	
}
