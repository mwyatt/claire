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
	// public $pathUpload = BASE_PATH . '/image/upload/';
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
	
	
	public function read()
	{	

		$sth = $this->database->dbh->query("	

			select
				id
				, file_name
				, title
				, title_slug
				, date_published
				, type
				, tree_id
				
			from
				main_media	

		");
		
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
		$val = friendly_url($val); // convert to friendly
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
	
	
	public function upload($files)
	{	
	
echo '<pre>';
print_r ($files);
echo '</pre>';
exit;	
	
	
	
		$files = rearrange($files); // tidy array	
	
		foreach ($files as $file) {
		
		
			// process filename
			$extension = $this->getExtension($file['name']);
			$title = $this->getTitle($file['name']);
			$fileName = $this->getFilename($file['name']);
		
		
			// file path
			$filePath = $this->dir.$fileName.$extension;
				
				
			// Keep Score
			$this->tick ++;

			
			
			
			// Duplicate
			if (file_exists($filePath)) {
			
				$this->error[$this->tick]['why'] = 'Duplicate File Found';
				$this->error[$this->tick]['title'] = $title;
				$this->error[$this->tick]['title_slug'] = $fileName;
				$this->error[$this->tick]['type'] = $file['type'];
				$this->error[$this->tick]['filename'] = $fileName.$extension;			
				$this->error[$this->tick]['user_id'] = $_SESSION['user']['id'];		
			
			// Too Big
			} elseif ($file['size'] > /* 2mb */ 2000000) {

			
				/*$image = new Image($file['tmp_name']);
				$image->resize(800, 600, 'crop');		
				$image->save($filePath.$fileName, 75);*/
			
				$this->error[$this->tick]['why'] = 'File too Big';
				$this->error[$this->tick]['title'] = $title;
				$this->error[$this->tick]['title_slug'] = $fileName;
				$this->error[$this->tick]['type'] = $file['type'];
				$this->error[$this->tick]['filename'] = $fileName.$extension;			
				$this->error[$this->tick]['user_id'] = $_SESSION['user']['id'];			
			
			// Success
			} elseif (move_uploaded_file($file['tmp_name'], $filePath)) {

				$this->upload[$this->tick]['title'] = $title;
				$this->upload[$this->tick]['title_slug'] = $fileName;
				$this->upload[$this->tick]['alt'] = $title;
				$this->upload[$this->tick]['type'] = $file['type'];
				$this->upload[$this->tick]['filename'] = $fileName.$extension;			
				$this->upload[$this->tick]['user_id'] = $_SESSION['user']['id'];	
				

			// Error				
			} else {
			
				$this->error[$this->tick]['why'] = 'Unknown Error Occurred';
				$this->error[$this->tick]['title'] = $title;
				$this->error[$this->tick]['title_slug'] = $fileName;
				$this->error[$this->tick]['type'] = $file['type'];
				$this->error[$this->tick]['filename'] = $fileName.$extension;			
				$this->error[$this->tick]['user_id'] = $_SESSION['user']['id'];	
				
			}			
		
		}
		
		if ($this->getError()) {
		
			return false;
		
		} else {
		
			$this->insert();	
		
		}
		
		return true;
					
	}
	

	/**
	  *	@returns result rows or false
	  */
	public function insert()
	{	
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