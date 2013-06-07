<?php

/**
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Model_Mainuser_Action extends Model
{


	public function read() {
		$sth = $this->database->dbh->prepare("
			select
				main_user_action.id
				, main_user_action.description
				, main_user_action.user_id
				, main_user_action.time
				, main_user_action.action
				, main_user_meta.name
				, main_user_meta.value
			from main_user_action
			left join main_user on main_user_action.user_id = main_user.id
			left join main_user_meta on main_user.id = main_user_meta.id
		");				
		$sth->bindParam(1, $id, PDO::PARAM_INT);
		$sth->bindParam(2, $id, PDO::PARAM_INT);
		$sth->execute();
		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			$row['guid'] = $this->getGuid('fixture', $row['team_left_name'] . '-' . $row['team_right_name'], $row['id']);
			$rows[] = $row;
		}
		if ($sth->rowCount()) {
			return $this->data = $rows;
		} 
		return false;
	}


}
