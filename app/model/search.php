<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
class Search extends Model
{

	/**
	  *	@return true on matching word or false
	  */
	public static function title($data)
	{		

		$data['title'] = strtolower($data['title']);
		$_POST['search'] = strtolower($_POST['search']);

		$titleWords = explode(' ', $data['title']); // split via ' '
		$searchWords = explode(' ', $_POST['search']); // split via ' '

		foreach ($titleWords as $titleWord) {
			foreach ($searchWords as $searchWord) {
			
				// each word matches and !== null
				if (
					($titleWord)
					&& ($searchWord)
					&& (strpos($titleWord, $searchWord) !== false)
				) {
					return true;
				}
			
			}
		}
		return false;
	}	


	/**
	 * search tables using search string
	 * team
	 * secretary
	 * player
	 * venue
	 * @param  string $searchString 
	 * @return array               
	 */
	public function read($searchString, $limit = 5) {

		if (! $searchString)
			return false;

		$searchWords = explode(' ', $searchString);
		$searchWords = array_map('strtolower', $searchWords);

		$sth = $this->database->dbh->query("	
			select
				tt_player.id
				, concat(tt_player.first_name, ' ', tt_player.last_name) as name
			from tt_player
		");
		
		$data1 = $sth->fetchAll(PDO::FETCH_ASSOC);
		foreach ($data1 as $key => $data)
			$data1[$key]['type'] = 'player';

		$sth = $this->database->dbh->query("	
			select
				tt_secretary.id
				, concat(tt_secretary.first_name, ' ', tt_secretary.last_name) as name
			from tt_secretary
		");

		$data2 = $sth->fetchAll(PDO::FETCH_ASSOC);
		foreach ($data2 as $key => $data)
			$data2[$key]['type'] = 'secretary';

		$sth = $this->database->dbh->query("	
			select
				tt_division.id
				, tt_division.name
			from tt_division
		");

		$data3 = $sth->fetchAll(PDO::FETCH_ASSOC);
		foreach ($data3 as $key => $data)
			$data3[$key]['type'] = 'division';

		$sth = $this->database->dbh->query("	
			select
				tt_team.id
				, tt_team.name
			from tt_team
		");

		$data4 = $sth->fetchAll(PDO::FETCH_ASSOC);
		foreach ($data4 as $key => $data)
			$data4[$key]['type'] = 'team';

		$sth = $this->database->dbh->query("	
			select
				tt_venue.id
				, tt_venue.name
			from tt_venue
		");

		$data5 = $sth->fetchAll(PDO::FETCH_ASSOC);
		foreach ($data5 as $key => $data)
			$data5[$key]['type'] = 'venue';

		$data = array_merge($data1, $data2, $data3, $data4, $data5);
		$scores = array();

		foreach ($data as $key => $file) {
			$score = 0;
			foreach ($searchWords as $searchWord) {
				if (strpos($data[$key]['id'], $searchWord) !== false)
					$score ++;
				$names = explode(' ', $data[$key]['name']);
				foreach ($names as $name) {
					if (strpos(strtolower($name), $searchWord) !== false)
						$score ++;
				}
				if (strpos(strtolower($data[$key]['name']), $searchWord) !== false)
					$score ++;
			}
			if (! $score)
				unset($data[$key]);
			else {
				$data[$key]['score'] = $score;
				$scores[$key] = $data[$key]['score'];
			}
		}
		array_multisort($scores, SORT_DESC, $data);

		$data = array_slice($data, 0, $limit);
		$this->setData(json_encode($data));

		if ($this->getData())
			return true;
		
	}

	
}