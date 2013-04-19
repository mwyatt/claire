<?php

/**
 * Page
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Model_Page extends Model_Maincontent
{
	
	public function create() {	
		$user = new Model_Mainuser($this->database, $this->config);

		if (! $this->validatePost($_POST, array('title', 'html'))) {
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
			, ':html' => $_POST['html']
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