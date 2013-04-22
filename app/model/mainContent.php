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
	public function read($where = '', $limit = 0, $id = false) {	
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
			" . ($where ? ' where main_content.type = :type ' : '') . "
			" . ($id ? ' and main_content.id = :id ' : '') . "
			group by main_content.id
			order by main_content.date_published
			" . ($limit ? ' limit 0, :limit ' : '') . "
		");
		if ($id) {
			$sth->bindValue(':id', $id, PDO::PARAM_STR);
		}
		if ($where) {
			$sth->bindValue(':type', $where, PDO::PARAM_STR);
		}
		if ($limit) {
			$sth->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
		}
		$sth->execute();	
		$this->setMeta($sth->fetchAll(PDO::FETCH_ASSOC));
		return $sth->rowCount();		
	}	


	public function readByType($type = 'post') {	
		$sth = $this->database->dbh->prepare("	
			select
				main_content.id
				, main_content.title
				, main_content.html
				, main_content.date_published
				, main_content.status
				, main_content.type
				, main_content_meta.name as meta_name
				, main_content_meta.value as meta_value
			from main_content
			left join main_content_meta on main_content_meta.content_id = main_content.id
			left join main_user on main_user.id = main_content.user_id
			where main_content.type = :type
			order by main_content.date_published
		");
		$sth->execute(array(
			':type' => $type
		));	
		$this->setMeta($sth->fetchAll(PDO::FETCH_ASSOC));
		return $sth->rowCount();
	}	

	public function readById($id) {	
		$sth = $this->database->dbh->prepare("	
			select
				main_content.id
				, main_content.title
				, main_content.html
				, main_content.date_published
				, main_content.status
				, main_content.type
				, main_content_meta.name as meta_name
				, main_content_meta.value as meta_value
			from main_content
			left join main_content_meta on main_content_meta.content_id = main_content.id
			left join main_user on main_user.id = main_content.user_id
			where main_content.id = :id
		");

		$sth->execute(array(
			':id' => $id
		));	
		$this->setMeta($sth->fetchAll(PDO::FETCH_ASSOC));
		$this->data = current($this->data);
		return $sth->rowCount();
	}

	public function readMedia($id) {	
		$sth = $this->database->dbh->prepare("	
			select
				main_content_meta.id
				, main_content_meta.content_id
				, main_content_meta.name
				, main_content_meta.value
			from main_content_meta
			where main_content_meta.content_id = :id
		");
		$sth->execute(array(
			':id' => $id
		));	
		$results = $sth->fetchAll(PDO::FETCH_ASSOC);
		$sth = $this->database->dbh->prepare("	
			select
				id
				, filename
				, basename
				, type
				, date_published
			from main_media
			where main_media.id = :id
		");
		foreach ($results as $result) {
			if ($result['name'] == 'media') {
				$sth->execute(array(
					':id' => $result['value']
				));	
			}
		}
		$results = $sth->fetchAll(PDO::FETCH_ASSOC);
		echo '<pre>';
		print_r($results);
		echo '</pre>';
		exit;
		

		
		$this->setMeta($sth->fetchAll(PDO::FETCH_ASSOC));
		$this->data = current($this->data);
		if (array_key_exists('media', $this->data)) {
			$this->data = $this->data['media'];
		} else {
			$this->data = false;
		}
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





	public function create() {	
		$user = new Model_Mainuser($this->database, $this->config);

		if (! $this->validatePost($_POST, array('title'))) {
			$this->session->set('feedback', 'All required fields must be filled');
			return false;
		}

		$sth = $this->database->dbh->prepare("
			insert into main_content (
				title
				, html
				, type
				, date_published
				, status
				, user_id
			)
			values (
				:title
				, :html
				, :type
				, :date_published
				, :status
				, :user_id
			)
		");				
		
		$sth->execute(array(
			':title' => $_POST['title']
			, ':html' => (array_key_exists('html', $_POST) ? $_POST['html'] : '')
			, ':type' => $_POST['type']
			, ':date_published' => time()
			, ':status' => $this->isChecked('status')
			, ':user_id' => $user->get('id')
		));		

		if ($sth->rowCount()) {
			$this->session->set('feedback', ucfirst($_POST['type']) . ' "' . $_POST['title'] . '" created');
			return $this->database->dbh->lastInsertId();
		}
		$this->session->set('feedback', 'Problem while creating ' . ucfirst($_POST['type']));
		return false;
	}
				
	public function update() {
		$user = new Model_Mainuser($this->database, $this->config);

		$sth = $this->database->dbh->prepare("
			select 
				title
				, html
				, type
				, date_published
				, status
				, user_id
			from main_content
			where id = ?
		");				

		$sth->execute(array(
			$_GET['edit']
		));		

		$row = $sth->fetch(PDO::FETCH_ASSOC);

		$sth = $this->database->dbh->prepare("
			update main_content set
				title = ?
				, html = ?
				, status = ?
			where
				id = ?
		");				
		
		$sth->execute(array(
			$_POST['title']
			, $_POST['html']
			, $this->isChecked('status')
			, $_GET['edit']
		));		

		if ($sth->rowCount()) {
			$this->session->set('feedback', ucfirst($row['type']) . ' "' . $row['title'] . '" updated');
			return true;
		}
		$this->session->set('feedback', 'Problem while updating');
		return false;
	}

}