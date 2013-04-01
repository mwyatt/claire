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

		// validation

		if (! $this->validatePost($_POST, array('title', 'html'))) {

			$this->getObject('mainUser')->setFeedback('All required fields must be filled');

			return false;
			
		}

		// prepare

		$sth = $this->database->dbh->prepare("
			insert into main_content
				(
					title
					, title_slug
					, html
					, type
					, date_published
					, status
					, user_id
				)
			values
				(
					:title
					, :title_slug
					, :html
					, :type
					, :date_published
					, :status
					, :user_id
				)
		");				
		
		$sth->execute(array(
			':title' => $_POST['title']
			, ':title_slug' => $this->urlFriendly($_POST['title'])
			, ':html' => $_POST['html']
			, ':type' => 'page'
			, ':date_published' => time()
			, ':status' => $this->isChecked('status')
			, ':user_id' => $this->getObject('mainUser')->get('id')
		));		

		// return & feedback

		if ($sth->rowCount()) {

			$this->getObject('Session')->set('feedback', array('success', 'Page Created'));
			return true;
			
		} else {

			$this->getObject('Session')->set('feedback', array('error', 'Page not Created'));
			return false;

		}
		
	}
				
}