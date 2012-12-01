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

 
class mainMedia extends Model
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
	
	
	/**
	 * all users are found
	 * create new setmetadatastaement, this method will pair the meta data with the normal data. grouping by the main id.
	 * @return null
	 */
	public function read()
	{	

		$sth = $this->database->dbh->query("	

			select
				main_media.id
				, main_media.file_name
				, main_media.title
				, main_media.date_published
				, main_media.type
				, main_user_meta.name

			from main_media

			left join main_user on main_user.id = main_media.user_id

			left join main_user_meta on main_user_meta.user_id = main_user.id

			group by main_media.id

		");
				// , case when main_user_meta.name = 'first_name' then main_user_meta.value end as user_first_name
				// , case when main_user_meta.name = 'last_name' then main_user_meta.value end as user_last_name
		




		$this->setDataStatement($sth);

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
	
	public function rearrange($array)
	{	
		foreach($array as $key => $files) {
			foreach($files as $i => $val) {
				$new[$i][$key] = $val;    
			}    
		}
		return $new;
	}
	
	
	/**
	 * upload and arrange multiple files, handles duplicates and too large items
	 * @param  array $files associative of the files uploaded
	 * @return bool        
	 */
	public function upload($files)
	{	

		// tidy array for readability

		$files = $this->rearrange($files['media']);

		// is array empty, improve this
	
		if (! $files[0]['name'])
			return false;

		// core files loop
	/*
	Array
	(
	    [0] => Array
	        (
	            [name] => formative essay draft 1.doc
	            [type] => application/msword
	            [tmp_name] => C:\xampp\tmp\php9DB.tmp
	            [error] => 0
	            [size] => 34304
	        )

	    [1] => Array
	        (
	            [name] => handbook.pdf
	            [type] => application/pdf
	            [tmp_name] => C:\xampp\tmp\php9DC.tmp
	            [error] => 0
	            [size] => 184531
	        )

	    [2] => Array
	        (
	            [name] => index.html
	            [type] => text/html
	            [tmp_name] => C:\xampp\tmp\php9DD.tmp
	            [error] => 0
	            [size] => 179
	        )

	    [3] => Array
	        (
	            [name] => index.php
	            [type] => application/octet-stream
	            [tmp_name] => C:\xampp\tmp\php9DE.tmp
	            [error] => 0
	            [size] => 179
	        )

	    [4] => Array
	        (
	            [name] => LijHgs3_3042723.php
	            [type] => application/octet-stream
	            [tmp_name] => C:\xampp\tmp\php9DF.tmp
	            [error] => 0
	            [size] => 708
	        )

	    [5] => Array
	        (
	            [name] => wp-config.php
	            [type] => application/octet-stream
	            [tmp_name] => C:\xampp\tmp\php9E0.tmp
	            [error] => 0
	            [size] => 3453
	        )

	)
	 */
		foreach ($files as $key => $file) {
				
			// process filename

			$fileName = $this->getFilename($file['name']);
			$extension = $this->getExtension($file['name']);
			$title = $this->getTitle($file['name']);
			
			// file path

			$filePath = BASE_PATH . 'img/upload/' . $fileName . $extension;
																
			// Duplicate

			if (file_exists($filePath)) {
			
				$this->getObject('Session')->set('feedback', array('error', 'Unable to upload file "' . $file['name'] . '" because it already exists'));

				return false;

			// Too Big (2mb)

			} elseif ($file['size'] > 2000000) {

				$this->getObject('Session')->set('feedback', array('error', 'Unable to upload file "' . $file['name'] . '" because it is too big'));

				return false;
			
			// Success

			} else {

				$filesSuccess[$key]['file'] = $file;
				$filesSuccess[$key]['file_name'] = $fileName;
				$filesSuccess[$key]['extension'] = $extension;
				$filesSuccess[$key]['title'] = $title;

/*
				id INT UNSIGNED NOT NULL AUTO_INCREMENT
				, file_name VARCHAR(255) NOT NULL
				, title VARCHAR(255)
				, date_published INT	
				, type VARCHAR(50) NOT NULL
				, user_id INT UNSIGNED*/

				// $this->upload[$key]['file_name'] = $fileName . $extension;
				// $this->upload[$key]['title'] = $title;
				// $this->upload[$key]['date_published'] = time();
				// $this->upload[$key]['type'] = $file['type'];
				// $this->upload[$key]['user_id'] = $this->getObject('mainUser')->get('id');
				
			// Error				

			}
		
		}

		// prepare

		$time = time();
		$userId = $this->upload[$key]['user_id'] = $this->getObject('mainUser')->get('id');

		$sth = $this->database->dbh->prepare("

			insert into main_media (file_name, title, date_published, type, user_id)

			values (:file_name, :title, $time, :type, $userId)

		");				
		
		$sth->execute(array(
			':first_name' => $_POST['first_name']
			, ':last_name' => $_POST['last_name']
			, ':rank' => $_POST['rank']
			, ':team_id' => $_POST['team_id']
		));

	echo '<pre>';
	print_r($filesSuccess);
	echo '</pre>';
	exit;
// (move_uploaded_file($file['tmp_name'], $filePath))

	}
	

	/**
	  *	@returns result rows or false
	  */
	public function create()
	{	
		echo '<pre>';
		print_r($this->upload);
		echo '</pre>';
		exit;
		

		$PDO = Database::getInstance(); // instance
		$SQL = "	
			INSERT INTO
				media
					(title, title_slug, alt, type, filename, user_id)			
				VALUE
					(:title, :title_slug, :alt, :type, :filename, :user_id)			
		";	

		
		$count = 0;
	
		foreach ($this->getUpload() as $file) {
		

		
			$STH = $PDO->dbh->prepare($SQL);
			
 
			$STH->execute($file); // execute

			$count += $STH->rowCount();
			
		}	
			
		return true;
			
	}
	
	
	/**
	  *	@returns true on success false on failure
	  */
	public function delete($id)
	{	
	
		$PDO = Database::getInstance(); // instance
		$SQL = "	
			DELETE FROM
				media
			WHERE
				id = '$id'		
		";
		
		$STH = $PDO->dbh->query($SQL);

		return ($STH->rowCount() ? true : false);
			
	}	
	
	
}