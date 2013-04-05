<?php

/**
 * Responsible for Various content types (Projects, Posts and Pages)
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Model_Maincontent extends Model
{	


	/**
	 * reads any and all content stored in this table
	 * a number of custom parameters can be used to
	 * bring in differing result sets
	 * @param  string $type  the type of content
	 * @param  string $limit the amount of content required
	 * @return null        data property will be set
	 */
	public function read($type = '', $limit = 0) {	
		if ($type) {
			$sthType = ' where main_content.type = :type ';
		}
		if ($limit) {
			$sthLimit = ' limit :limit ';
		}
		$sth = $this->database->dbh->prepare("	
			select
				main_content.id
				, main_content.title
				, main_content.html
				, main_content.type
				, main_content.date_published
				, main_content.status
				, main_content.user_id
				, main_content_meta.name as meta_name
				, main_content_meta.value as meta_value
			from main_content
			left join main_content_meta on main_content_meta.content_id = main_content.id
			left join main_user on main_user.id = main_content.user_id
			$sthType
			order by main_content.date_published
			$sthLimit
		");
		if ($type) {
			$sth->bindValue(':type', $type, PDO::PARAM_STR);
		}
		if ($limit) {
			$sth->bindValue(':limit', $limit, PDO::PARAM_INT);	
		}
		$sth->execute();	
		$this->setDataStatement($sth);
		echo '<pre>';
		print_r($this->data);
		echo '</pre>';
		exit;
	}	


	public function readByType($type = 'post')
	{	
	
		$sth = $this->database->dbh->prepare("	

			select
				main_content.id
				, main_content.title
				, main_content.title_slug
				, main_content.html
				, main_content.date_published
				, main_content.guid
				, main_content.status
				, main_content.type
				, main_content_meta.name as meta_name
				, main_content_meta.value as meta_value

			from main_content

			left join
				main_content_meta on main_content_meta.content_id = main_content.id

			left join
				main_user on main_user.id = main_content.user_id

			where
				main_content.type = :type

			order by
				main_content.date_published

		");

		$sth->execute(array(
			':type' => $type
		));	

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			if (! array_key_exists($row['id'], $this->data)) {
				$this->data[$row['id']] = $row;
				$this->data[$row['id']]['guid'] = $this->getGuid('post', $row['title'], $row['id']);
			}
			if ($row['meta_name'])
				$this->data[$row['id']][$row['meta_name']] = $row['meta_value'];
		}

		return $sth->rowCount();
	}	

	public function readById($id)
	{	
	
		$sth = $this->database->dbh->prepare("	

			select
				main_content.id
				, main_content.title
				, main_content.title_slug
				, main_content.html
				, main_content.date_published
				, main_content.guid
				, main_content.status
				, main_content.type
				, main_content_meta.name as meta_name
				, main_content_meta.value as meta_value

			from main_content

			left join
				main_content_meta on main_content_meta.content_id = main_content.id

			left join
				main_user on main_user.id = main_content.user_id

			where
				main_content.id = :id

		");

		$sth->execute(array(
			':id' => $id
		));	

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			if (! array_key_exists($row['id'], $this->data)) {
				$this->data[$row['id']] = $row;
				$this->data[$row['id']]['guid'] = $this->getGuid('post', $row['title'], $row['id']);
			}
			if ($row['meta_name'])
				$this->data[$row['id']][$row['meta_name']] = $row['meta_value'];
		}
		$this->data = current($this->data);

		return $sth->rowCount();
	}

	public function readByTitleSlug($titleSlug) {
		$sth = $this->database->dbh->prepare("	
			select
				main_content.id
				, main_content.title
				, main_content.title_slug
				, main_content.html
				, main_content.date_published
				, main_content.guid
				, main_content.status
				, main_content.type
				, main_content_meta.name as meta_name
				, main_content_meta.value as meta_value

			from main_content

			left join
				main_content_meta on main_content_meta.content_id = main_content.id

			left join
				main_user on main_user.id = main_content.user_id

			where
				main_content.title_slug = :title_slug
				and
				main_content.type = 'page'
		");

		$sth->execute(array(
			':title_slug' => $titleSlug
		));	

		while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
			if (! array_key_exists($row['id'], $this->data)) {
				$this->data[$row['id']] = $row;
			}
			if (array_key_exists('meta_name', $row)) {
				$this->data[$row['id']][$row['meta_name']] = $row['meta_value'];
				unset($this->data[$row['id']]['meta_name']);
				unset($this->data[$row['id']]['meta_value']);
			}
		}
		$this->data = current($this->data);
		return $sth->rowCount();
	}

}