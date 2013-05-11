<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
 /*
 id, title, filename, guid, date_published, description, type, media_tree_id
 1, My Little Pony, $pathUpload . filename, The Pony is so Beautiful!, gif, 0
 */
/*
		CREATE NEW IMAGE THUMBS ON UPLOAD

				$image = new Image($filePath.$fileName);
				$image->resize($width, $height, 'crop');		
				$image->save($filePath.$fileName, 100);
				$this->result[$i]['thumb'] = $fileName; // set ['thumb']
*/

 
class Model_Mainmedia extends Model
{
	
	protected $tick = 0;
	public $upload;
	public $error;
	public $thumb = array(
		'small' => array(
			'width' => 250, 'height' => 250
		),
		'medium' => array(
			'width' => 450, 'height' => 450
		),
		'large' => array(
			'width' => 650, 'height' => 650
		)
	);
	public $dir = 'img/upload/';

	
	public function read($id) {	
		$or = '';
		if (is_array($id)) {
			$ids = $id;
			foreach ($ids as $id) {
				$or .= " or main_media.id = '$id' ";
			}
		}
		$sth = $this->database->dbh->query("	
			select
				id
				, path
				, date_published
				, user_id
			from main_media
			where main_media.id = '$id'
			$or
			group by main_media.id
		");
		return $this->data = $this->setData($sth->fetchAll(PDO::FETCH_ASSOC));
	}	

	public function setData($rows) {
		foreach ($rows as $key => $row) {
			$rows[$key]['guid'] = $this->getGuid('media', $row['basename']);
		}
		return $rows;
	}
	
	
	public function getExtension($val)
	{	
		$val = explode('.', $val); // split via '.'
		$val = end($val);
		$val = strtolower('.'.$val); // .JPG -> .jpg
		return ($val ? $val : false);	
	}
	
	
	public function getTitle($val)
	{	
		$val = explode('.', $val); // split via '.
		array_pop($val);
		$val = implode($val);
		return ($val ? $val : false);			
	}
	
	public function getFilename($val)
	{	
		$val = explode('.', $val); // split via '.
		array_pop($val);
		$val = implode($val);
		$val = $this->getObject('View')->urlFriendly($val); // convert to friendly
		return ($val ? $val : false);			
	}
	
	
	public function getError()
	{	
		return ($this->error ? $this->error : false);
	}
	
	
	public function getUpload()
	{	
		return ($this->upload ? $this->upload : false);
	}
	

	/**
	 * tidies up the files array to more readable format
	 * @param  array $array $_FILES['media'] preferrably
	 * @return array        the sorted array
	 */
	public function tidyFiles($array) {	
		foreach($array as $key => $files) {
			foreach($files as $i => $val) {
				$new[$i][$key] = $val;    
			}    
		}
		return $new;
	}
	

	/**
	 * uploads the files and attaches them to the content id provided
	 * @param  int $id the id of the recently created content
	 * @return bool  
	 */
	public function uploadAttach($contentId) {
		$files = $_FILES;
		if (empty($files) || ! array_key_exists('media', $files)) {
			return;
		}
		$uploadPath = BASE_PATH . $this->dir;
		$files = $this->tidyFiles($files['media']);
		$sthMedia = $this->database->dbh->prepare("
			insert into main_media (
				path
				, date_published
				, user_id
			)
			values (
				:path
				, :date_published
				, :user_id
			)
		");		
		$sthContentMeta = $this->database->dbh->prepare("
			insert into main_content_meta (
				content_id
				, name
				, value
			)
			values (
				:content_id
				, :name
				, :value
			)
		");			
		foreach ($files as $key => $file) {
			$fileInformation = pathinfo($file['name']);
			$filePath = $uploadPath . $fileInformation['basename'];

			if ($file['error']) {
				return false;
			}

			if (
				$file['type'] != 'image/gif'
				&& $file['type'] != 'image/png'
				&& $file['type'] != 'image/jpeg'
				&& $file['type'] != 'image/pjpeg'
				&& $file['type'] != 'image/jpeg'
				&& $file['type'] != 'image/pjpeg'
				&& $file['type'] != 'application/pdf'
			) {
				$this->session->set('feedback', 'File must be .gif, .jpg, .png or .pdf');
				return false;
			}

			if (file_exists($filePath)) {
				$this->session->set('feedback', 'Unable to upload file "' . $file['name'] . '" because it already exists');
				return false;
			}

			if ($file['size'] > 2000000 /* 2mb */) {
				$this->session->set('feedback', 'Unable to upload file "' . $file['name'] . '" because it is too big');
				return false;
			}

			if (! move_uploaded_file($file['tmp_name'], $filePath)) {
				$this->session->set('feedback', 'While moving the temporary file an error occured');
				return false;
			}

			$sthMedia->execute(array(
				':path' => $fileInformation['basename']
				, ':date_published' => time()
				, ':user_id' => $this->session->get('user', 'id')
			));

			$mediaId = $this->database->dbh->lastInsertId();

			$sthContentMeta->execute(array(
				':content_id' => $contentId
				, ':name' => 'media'
				, ':value' => $mediaId
			));
		}
		return true;
	}

	
	/**
	 * upload and arrange multiple files, handles duplicates and
	 * too large items
	 * @param  array $files associative of the files uploaded
	 * @return bool        
	 */
	// public function upload($files)
	// {	

	// 	$uploadPath = BASE_PATH . $this->dir;

	// 	// tidy array for readability

	// 	$files = $this->tidyFiles($files['media']);

	// 	// is array empty, improve this
	
	// 	if (! $files[0]['name'])
	// 		return false;

	// 	// core files loop

	// 	foreach ($files as $key => $file) {
				
	// 		// process filename

	// 		$fileName = $this->getFilename($file['name']);
	// 		$extension = $this->getExtension($file['name']);
	// 		$title = $this->getTitle($file['name']);

	// 		// check type
	// 		if (($file['type'] !== 'image/gif')
	// 			&& ($file['type'] !== 'image/png')
	// 			&& ($file['type'] !== 'image/jpeg')
	// 			&& ($file['type'] !== 'image/pjpeg')
	// 			&& ($file['type'] !== 'image/jpeg')
	// 			&& ($file['type'] !== 'image/pjpeg')
	// 			) {

	// 			$this->getObject('Session')->set('feedback', array('error', 'Unable to upload file "' . $file['name'] . '" because it is an unacceptable type'));

	// 			return false;	

	// 		}
																
	// 		// Duplicate

	// 		if (file_exists($uploadPath . $fileName . $extension)) {
			
	// 			$this->getObject('Session')->set('feedback', array('error', 'Unable to upload file "' . $file['name'] . '" because it already exists'));

	// 			return false;

	// 		}

	// 		// Too Big (2mb)

	// 		if ($file['size'] > 2000000) {

	// 			$this->getObject('Session')->set('feedback', array('error', 'Unable to upload file "' . $file['name'] . '" because it is too big'));

	// 			return false;
			
	// 		}

	// 		$filesSuccess[$key]['file'] = $file;
	// 		$filesSuccess[$key]['file_name'] = $fileName;
	// 		$filesSuccess[$key]['extension'] = $extension;
	// 		$filesSuccess[$key]['title'] = $title;
		
	// 	}

	// 	// prepare

	// 	$time = time();
	// 	$userId = $this->upload[$key]['user_id'] = $this->getObject('mainUser')->get('id');

	// 	$sth = $this->database->dbh->prepare("

	// 		insert into main_media (file_name, title, date_published, type, user_id)

	// 		values (:file_name, :title, $time, :type, $userId)

	// 	");				

	// 	$uploadedFileNames = '';

	// 	foreach ($filesSuccess as $key => $file) {

	// 		move_uploaded_file($file['file']['tmp_name'], $uploadPath . $file['file_name'] . $file['extension']);
			
	// 		$sth->execute(array(
	// 			':file_name' => $file['file_name'] . $file['extension']
	// 			, ':title' => $file['title']
	// 			, ':type' => $file['file']['type']
	// 		));

	// 		$uploadedFileNames .= $file['title'] . ', ';

	// 	}

	// 	$uploadedFileNames = rtrim($uploadedFileNames, ', ');

	// 	$this->getObject('Session')->set('feedback', array('success', 'Uploaded ' . $uploadedFileNames));

	// }
	

	/**
	  *	@returns result rows or false
	  */
	// public function create()
	// {	
	// 	echo '<pre>';
	// 	print_r($this->upload);
	// 	echo '</pre>';
	// 	exit;
		

	// 	$PDO = Database::getInstance(); // instance
	// 	$SQL = "	
	// 		INSERT INTO
	// 			media
	// 				(title, title_slug, alt, type, filename, user_id)			
	// 			VALUE
	// 				(:title, :title_slug, :alt, :type, :filename, :user_id)			
	// 	";	

		
	// 	$count = 0;
	
	// 	foreach ($this->getUpload() as $file) {
		

		
	// 		$STH = $PDO->dbh->prepare($SQL);
			
 
	// 		$STH->execute($file); // execute

	// 		$count += $STH->rowCount();
			
	// 	}	
			
	// 	return true;
			
	// }
	
	
	/**
	 * delete media by ID
	 * @param  int $id 
	 * @return bool     
	 */
	// public function deleteById($id)
	// {	
	
	// 	// are you tied to any posts?

	// 	$sth = $this->database->dbh->prepare("

	// 		select
	// 			main_content_media.id
	// 		from
	// 			main_content_media
	// 		where
	// 			main_content_media.media_id = $id

	// 	");				

	// 	$sth->execute();

	// 	if ($sth->rowCount()) {

	// 		$this->getObject('Session')->set('feedback', array('error', 'Unable to delete media, it is attached to posts'));

	// 		return;
			
	// 	}

	// 	// delete

	// 	$sth = $this->database->dbh->prepare("

	// 		select
	// 			main_media.id
	// 			, main_media.file_name
	// 			, main_media.title
	// 			, main_media.date_published
	// 			, main_media.type
	// 		from
	// 			main_media
	// 		where
	// 			main_media.id = $id

	// 	");				

	// 	$sth->execute();

	// 	if ($row = $sth->fetch()) {
			
	// 		$file = BASE_PATH . $this->dir . $row['file_name'];

	// 		if (is_file($file))
	// 		  unlink($file);

	// 	}

	// 	$sth = $this->database->dbh->prepare("

	// 		delete from
	// 			main_media
	// 		where
	// 			main_media.id = $id

	// 	");	

	// 	$sth->execute();

	// 	if ($sth->rowCount()) {

	// 		$this->getObject('Session')->set('feedback', array('success', '"' . $row['title'] .'" Deleted'));

	// 	}

	// }
	
	
}


// <?php

// /**
//  * @package	~unknown~
//  * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
//  * @version	0.1
//  * @license http://www.php.net/license/3_01.txt PHP License 3.01
//  */ 
//  /*
//  id, title, filename, guid, date_published, description, type, media_tree_id
//  1, My Little Pony, $pathUpload . filename, The Pony is so Beautiful!, gif, 0
//  */
// /*
// 		CREATE NEW IMAGE THUMBS ON UPLOAD

// 				$image = new Image($filePath.$fileName);
// 				$image->resize($width, $height, 'crop');		
// 				$image->save($filePath.$fileName, 100);
// 				$this->result[$i]['thumb'] = $fileName; // set ['thumb']
// */

 
// class Model_Mainmedia extends Model
// {
	
// 	protected $tick = 0;
// 	public $pathUpload = BASE_PATH . '/image/upload/';
// 	public $upload;
// 	public $error;
// 	public $thumb = array(
// 		'small' => array(
// 			'width' => 250, 'height' => 250
// 		),
// 		'medium' => array(
// 			'width' => 450, 'height' => 450
// 		),
// 		'large' => array(
// 			'width' => 650, 'height' => 650
// 		)
// 	);
	
	
// 	/**
// 	 * Select data based on @param
// 	 * @result true if @param result isset false on failure
// 	 */ 
// 	public function select($id = null)
// 	{	
// 		// PDO
// 		$PDO = Database::getInstance();
// 		$SQL = "	
// 			SELECT
// 				id
// 				, title
// 				, title_slug
// 				, date_uploaded
// 				, alt
// 				, description
// 				, media_tree_id
// 				, type
// 				, filename
// 				, user_id
// 			FROM
// 				media	
// 		";

// 		// Append SQL
// 		$SQL .= ($id != null ? "WHERE id = '$id'" : ""); // extend
		
// 		// Execute SQL
// 		$STH = $PDO->dbh->query($SQL);
		
// 		// Return
// 		return $this->setResult(
// 			($STH->rowCount() > 0 ? $STH->fetchAll(PDO::FETCH_ASSOC) : false)
// 		);
// 	}
	
	
// 	public function getExtension($val)
// 	{	
// 		$val = explode('.', $val); // split via '.'
// 		$val = end($val);
// 		$val = strtolower('.'.$val); // .JPG -> .jpg
// 		return ($val ? $val : false);	
// 	}
	
	
// 	public function getTitle($val)
// 	{	
// 		$val = explode('.', $val); // split via '.
// 		array_pop($val);
// 		$val = implode($val);
// 		return ($val ? $val : false);			
// 	}
	
// 	public function getFilename($val)
// 	{	
// 		$val = explode('.', $val); // split via '.
// 		array_pop($val);
// 		$val = implode($val);
// 		$val = friendly_url($val); // convert to friendly
// 		return ($val ? $val : false);			
// 	}
	
	
// 	public function getError()
// 	{	
// 		return ($this->error ? $this->error : false);
// 	}
	
	
// 	public function getUpload()
// 	{	
// 		return ($this->upload ? $this->upload : false);
// 	}
	
	
// 	public function upload($files)
// 	{	
	
// echo '<pre>';
// print_r ($files);
// echo '</pre>';
// exit;	
	
	
	
// 		$files = rearrange($files); // tidy array	
	
// 		foreach ($files as $file) {
		
		
// 			// process filename
// 			$extension = $this->getExtension($file['name']);
// 			$title = $this->getTitle($file['name']);
// 			$fileName = $this->getFilename($file['name']);
		
		
// 			// file path
// 			$filePath = $this->dir.$fileName.$extension;
				
				
// 			// Keep Score
// 			$this->tick ++;

			
			
			
// 			// Duplicate
// 			if (file_exists($filePath)) {
			
// 				$this->error[$this->tick]['why'] = 'Duplicate File Found';
// 				$this->error[$this->tick]['title'] = $title;
// 				$this->error[$this->tick]['title_slug'] = $fileName;
// 				$this->error[$this->tick]['type'] = $file['type'];
// 				$this->error[$this->tick]['filename'] = $fileName.$extension;			
// 				$this->error[$this->tick]['user_id'] = $_SESSION['user']['id'];		
			
// 			// Too Big
// 			} elseif ($file['size'] > /* 2mb */ 2000000) {

			
// 				/*$image = new Image($file['tmp_name']);
// 				$image->resize(800, 600, 'crop');		
// 				$image->save($filePath.$fileName, 75);*/
			
// 				$this->error[$this->tick]['why'] = 'File too Big';
// 				$this->error[$this->tick]['title'] = $title;
// 				$this->error[$this->tick]['title_slug'] = $fileName;
// 				$this->error[$this->tick]['type'] = $file['type'];
// 				$this->error[$this->tick]['filename'] = $fileName.$extension;			
// 				$this->error[$this->tick]['user_id'] = $_SESSION['user']['id'];			
			
// 			// Success
// 			} elseif (move_uploaded_file($file['tmp_name'], $filePath)) {

// 				$this->upload[$this->tick]['title'] = $title;
// 				$this->upload[$this->tick]['title_slug'] = $fileName;
// 				$this->upload[$this->tick]['alt'] = $title;
// 				$this->upload[$this->tick]['type'] = $file['type'];
// 				$this->upload[$this->tick]['filename'] = $fileName.$extension;			
// 				$this->upload[$this->tick]['user_id'] = $_SESSION['user']['id'];	
				

// 			// Error				
// 			} else {
			
// 				$this->error[$this->tick]['why'] = 'Unknown Error Occurred';
// 				$this->error[$this->tick]['title'] = $title;
// 				$this->error[$this->tick]['title_slug'] = $fileName;
// 				$this->error[$this->tick]['type'] = $file['type'];
// 				$this->error[$this->tick]['filename'] = $fileName.$extension;			
// 				$this->error[$this->tick]['user_id'] = $_SESSION['user']['id'];	
				
// 			}			
		
// 		}
		
// 		if ($this->getError()) {
		
// 			return false;
		
// 		} else {
		
// 			$this->insert();	
		
// 		}
		
// 		return true;
					
// 	}
	

// 	/**
// 	  *	@returns result rows or false
// 	  */
// 	public function insert()
// 	{	
// 		$PDO = Database::getInstance(); // instance
// 		$SQL = "	
// 			INSERT INTO
// 				media
// 					(title, title_slug, alt, type, filename, user_id)			
// 				VALUE
// 					(:title, :title_slug, :alt, :type, :filename, :user_id)			
// 		";	

		
// 		$count = 0;
	
// 		foreach ($this->getUpload() as $file) {
		

		
// 			$STH = $PDO->dbh->prepare($SQL);
			
 
// 			$STH->execute($file); // execute

// 			$count += $STH->rowCount();
			
// 		}	
			
// 		return true;
			
// 	}
	
	
// 	/**
// 	  *	@returns true on success false on failure
// 	  */
// 	public function delete($id)
// 	{	
	
// 		$PDO = Database::getInstance(); // instance
// 		$SQL = "	
// 			DELETE FROM
// 				media
// 			WHERE
// 				id = '$id'		
// 		";
		
// 		$STH = $PDO->dbh->query($SQL);

// 		return ($STH->rowCount() ? true : false);
			
// 	}	
	
	
// }