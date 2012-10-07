<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
class Menu extends Model
{


	// variables
	public $type;
	public $html;
	
	
	public function __construct($DBH, $urlBase, $url) {
		$this->DBH = $DBH;
		$this->urlBase = $urlBase;	
		$this->url = $url;
	}
	
	
	/**
	 * Works with methods to return a full tree of type
	 * @param string type
	 * @returns	true if successful, false otherwise
	 */	
	public function create($type, $parent = 0)
	{
		// Set type
		$this->type = $type;
		
		// Select Menu
		$this->select($type, $parent);
		
		// Build Menu
		if ($this->getResult()) {
			return '<nav id="'.$this->type.'">'.$this->build($this->result).'</nav>';
		} else {
			return false;
		}
	}	
	
	
	/**
	 * Works with methods to return a full tree of type
	 * @method		build
	 * @param		array results
	 * @returns	html output if successful, false otherwise
	 */	
	public function build($results, $parent = 0)
	{		
		$html = '<ol class="depth_'.$parent.'">';
		
		foreach ($results as $result) {
			if ($result['parent_id'] == $parent) {
				
				// Construct Class Attribute
				$class = '';
				$class .= 'class="';
				$class .= 'id_'.$result['id'].' ';
				$class .= ($this->getUrl(1) == $result['title'] ? ' current' : false);
				$class .= '"';
				
				// Append List Item
				$html .= '<li '.$class.'><div><a href="'.$result['guid'].'">'.$result['title'].'</a></div>';
				
				if ($this->hasChild($results, $result['id'])) {
					$html .= $this->build($results, $result['id']);
					$html .= '</li>';
				}
				
			}
		}
		
		$html .= '</ol>';		
		
		// Return
		return $this->html = $html;
	}	
	
	
	/**
	  *	Works with method build
	  *	@method		hasChild
	  *	@param		array results
	  *	@id			string id
	  *	@returns	children if successful, false otherwise
	  */	
	public function hasChild($results, $id)
	{
		foreach ($results as $result) {
			if ($result['parent_id'] == $id)
			return true;
		}
		return false;
	}	
	
	
	/**
	  *	Gets a full menu tree
	  *	@method		get
	  *	@param		string type
	  *	@returns	assoc array if successful, empty array otherwise
	  */
	private function select($type, $parent)
	{		
		if ($type == null) { return false; } // check for false 
	
		$SQL = "
			SELECT
				id
				, title
				, guid
				, parent_id
				, position
				, type
			FROM
				menu
			WHERE
				type = '$type'
			ORDER BY
				position ASC
		";
		$STH = $this->DBH->query($SQL); // execute	

		return $this->setResult($STH->fetchAll(PDO::FETCH_ASSOC));
	}
	
	
	/**
	  *	Builds menu tree for admin area
	  *	@param		string type
	  *	@returns	assoc array if successful, empty array otherwise
	  */
	public function ccBuild($parent = 0)
    {
		$i = 0;
		$dir = 'app/cc/controller/'; // set dir
		
		if ($dirHandle = opendir($dir)) { // find controllers
		
			$html = '<ol class="ccMenu">';
			
			$url = $this->getUrlBase().'cc/';
			$current = ($this->getUrl(2) ? false : ' class="current"');
			
			$html .= '<li'.$current.'><div><a href="'.$url.'">Dashboard</a></div></li>';
					
					
			// loop		
			while (($file = readdir($dirHandle)) !== false) {
			
				if ($file != "." && $file != ".." && $file != ".htaccess" && $file != "index.php") { // filter
				
					$title = $file;
					$url = $this->getUrlBase().'cc/'.$title.'/';
					//$icon = (file_exists($dir.'/'.$file.'/assets/img/cms_icon.png') ? $dir.'/'.$file.'/cms_icon.png' : 'assets/img/32x32.gif'); // needs work
					
					$current = ($this->getUrl(2) == $file ? ' class="current"' : false);
					
					$html .= '<li'.$current.'><div><a href="'.$url.'">'.$title.'</a></div></li>';
		
				}
				
			}
			
			$html .= '</ol>';						
			
			closedir($dirHandle); // close
			
			return $this->html = $html;
		}
		return false;
    }	

	
	/**
	  * adds subtree to items array
	  * currently unused
	  */
/*	  
	public function buildSubTree()
    {
		foreach ($this->items as $rootKey => $item) {
			foreach ($item as $key => $val) {
				if ($key == 'current' && $val == true) {
				
					$i = 0;
					$dir = Config::read('dir.cc.controller').$this->items[$rootKey]['name'].'/sub/'; // set dir
					if ($dirHandle = opendir($dir)) { // find subNav
						while (($file = readdir($dirHandle)) !== false) { // loop over files
							if ($file != "." && $file != ".." && $file != ".htaccess" && $file != "index.php" && $file != "ajax") { // filter
								$this->items[$rootKey]['subNav'][$i]['path'] = $dir.$file;
								$file = preg_replace('/[.$](php)+/', '', $file); // remove .php
								$this->items[$rootKey]['subNav'][$i]['name'] = $file;
								if ($this->getUrl(3) == $file) {
									$this->items[$rootKey]['subNav'][$i]['current'] = true;
								}								
								$i++;
							}
						}
						// close
						closedir($dirHandle);
						return true;
					}					
				}
			}
		}
		return false;
    }	*/
	
}