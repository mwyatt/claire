<?php

/**
 * Menu Crafter
 *
 * PHP version 5
 * 
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class mainMenu extends Model
{

	public $type;
	public $html = '';
	public $adminSubMenu;

	
	public function getAdminSubMenu()
	{		
		
		if ($this->adminSubMenu)

			echo $this->adminSubMenu;

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
		if ($parent)
			$parent = " AND parent_id = '{$parent}' ";
	
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
				type = '{$type}'
			{$parent}
			ORDER BY
				position ASC
		";
		$sth = $this->database->dbh->query($SQL); // execute	

		return $this->setResult($sth->fetchAll(PDO::FETCH_ASSOC));
		
	}	
	
	
	/**
	 * Works with methods to return a full tree of type
	 * @param string type
	 * @returns	true if successful, false otherwise
	 */	
	public function create($type, $parent = false)
	{
		
		$this->type = $type;
		$this->select($type, $parent);
		
		if ($this->getResult())
			return '<nav id="'.$this->type.'">'.$this->build($this->getResult()).'</nav>';
		else
			return false;
			
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
				$class .= ($this->config->getUrl(0) == $result['title'] ? ' current' : false);
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
	  *	Builds menu tree for admin area
	  *	@param		string type
	  *	@returns	assoc array if successful, empty array otherwise
	  */
	public function adminBuild($parent = 0)
    {

    	$user = $this->getObject('mainUser')->get();

		$path = 'app/controller/' . $this->config->getUrl(0). '/'; // set dir
		
		if ($handle = opendir($path)) {
		
			$html = '<ul>';
			
			$adminBaseUrl = $this->config->getUrl('base') . $this->config->getUrl(0). '/';

			$current = (! $this->config->getUrl(1) ? ' class="current"' : false);
			
			$html .= '<li' . $current . '><a href="' . $adminBaseUrl . '">Dashboard</a></li>';
					
			while (($file = readdir($handle)) !== false) {
			
				if ($file != "." && $file != ".." && $file != ".htaccess" && $file != "index.php") {
				
					if (strpos($file, '.php')) {

						$title = str_replace('.php', '', $file);
						
						$adminBaseUrl = $this->config->getUrl('base') . $this->config->getUrl(0) . '/' . $title . '/';
						
						//$icon = (file_exists($path.'/'.$file.'/assets/img/cms_icon.png') ? $path.'/'.$file.'/cms_icon.png' : 'assets/img/32x32.gif'); // needs work
						
						$current = ($this->config->getUrl(1) == $title ? ' class="current"' : false);
						
						$html .= '<li'.$current.'><a href="'.$adminBaseUrl.'">'.$title.'</a></li>';
						
					} else {

						$folders[] = $file;

					}
		
				}
				
			}

			$html .= '<div class="clearfix"></div>';						
			$html .= '</ul>';						
			
			closedir($handle); // close

			// sub menu

			foreach ($folders as $folder) {

				if ($this->config->getUrl(1) == $folder) {

					$path = 'app/controller/admin/' . $folder . '/';

					if ($handle = opendir($path)) {

						$this->adminSubMenu = '<nav class="sub">';
						$this->adminSubMenu .= '<ul>';
						
						$folderBaseUrl = $this->config->getUrl('base') . $this->config->getUrl(0) . '/league/';

						while (($file = readdir($handle)) !== false) {
						
							if ($file != "." && $file != ".." && $file != ".htaccess" && $file != "index.php") {
							
								if (strpos($file, '.php')) {

									$title = str_replace('.php', '', $file);
									
									$url = $this->config->getUrl('base') . $this->config->getUrl(0) . '/' . $this->config->getUrl(1) . '/' . $title . '/';
									
									$current = ($this->config->getUrl(2) == $title ? ' class="current"' : false);
									
									$this->adminSubMenu .= '<li' . $current . '><a href="' . $url . '">' . $title . '</a></li>';
									
								}
						
							}
							
						}

						$this->adminSubMenu .= '<div class="clearfix"></div>';
						$this->adminSubMenu .= '</ul>';
						$this->adminSubMenu .= '</nav>';

					}

				}

			}
			
			return $this->html = $html;

		}

		return false;

    }	


    public function buildDivision() {
    	$ttDivision = new ttDivision($this->database, $this->config);
    	$ttDivision->read();
		$this->html .= '<nav>';
    	foreach ($ttDivision->getData() as $division) {
    		$division['lowername'] = strtolower($division['name']);
    		$this->html .= '<div>
                    <a href="' . $this->config->getUrl('base') . 'result/' . $division['lowername'] . '/">' . $division['name'] . '<span>3</span></a>
                    <div>
                        <div><a href="' . $this->config->getUrl('base') . 'result/' . $division['lowername'] . '/merit/"">Merit Table</a></div>
                        <div><a href="' . $this->config->getUrl('base') . 'result/' . $division['lowername'] . '/league/"">League Table</a></div>
                        <div><a href="' . $this->config->getUrl('base') . 'result/' . $division['lowername'] . '/fixture/"">Fixtures</a></div>
                    </div>
                </div>';
    	}
		$this->html .= '</nav>';
    	return $this->html;
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
								if ($this->config->getUrl(2) == $file) {
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