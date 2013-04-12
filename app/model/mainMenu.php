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
class Model_mainMenu extends Model
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
	 * attempts to find a sub controller and builds a nav menu using its
	 * methods (?page=method)
	 * @return html the menu
	 */
	public function adminSub() {
		$html = '';
		$className = 'Controller_' . ucfirst($this->config->getUrl(0)) . '_' . ucfirst($this->config->getUrl(1));

		if (class_exists($className)) {
			$html = '<nav class="sub">';
			$html .= '<ul>';
			$baseUrl = $this->config->getUrl('base') . $this->config->getUrl(0) . '/' . $this->config->getUrl(1). '/';
			$page = (array_key_exists('page', $_GET) ? $_GET['page'] : '');

			$current = ($page == '' ? ' class="current"' : '');
			$html .= '<li' . $current . '><a href="' . $baseUrl . '">Overview</a></li>';

			foreach (get_class_methods($className) as $method) {
				if ($method == '__construct') {
					break;
				}

				if (($method != 'initialise') || ($method != 'index')) {
					$current = ($page == $method ? ' class="current"' : '');
					$html .= '<li' . $current . '><a href="' . $baseUrl . '?page=' . $method . '">' . $method . '</a></li>';
				}
			}

			$html .= '<div class="clearfix"></div>';						
			$html .= '</ul>';
			$html .= '</nav>';						
		}

		return $html;
	}


	/**
	  *	Builds menu tree for admin area
	  *	@param		string type
	  *	@returns	assoc array if successful, empty array otherwise
	  */
	public function admin()
    {
		$html = '<ul>';
		$baseUrl = $this->config->getUrl('base') . $this->config->getUrl(0). '/';

		$current = ($this->config->getUrl(1) == '' ? ' class="current"' : '');
		$html .= '<li' . $current . '><a href="' . $baseUrl . '">Dashboard</a></li>';
		

		foreach (get_class_methods('Controller_Admin') as $method) {
			if ($method == '__construct') {
				break;
			}
			if (($method == 'initialise') || ($method == 'index')) {

			} else {
				$current = ($this->config->getUrl(1) == $method ? ' class="current"' : '');
				$html .= '<li' . $current . '><a href="' . $baseUrl . $method . '/">' . $method . '</a></li>';
			}

		}

		$html .= '</ul>';		
		return $html;
    }	


    public function buildDivision() {
    	$ttDivision = new Model_Ttdivision($this->database, $this->config);
    	$ttDivision->read();
		$this->html .= '<ul>';
    	foreach ($ttDivision->getData() as $division) {
    		$division['lowername'] = strtolower($division['name']);
    		$this->html .= '
    			<li>
    				<div>
    					<span></span>
	                    <a href="#">' . $division['name'] . '</a>
	                    <ul>
	                        <li><a href="' . $this->config->getUrl('base') . 'result/' . $division['lowername'] . '/">Overview</a></li>
	                        <li><a href="' . $this->config->getUrl('base') . 'result/' . $division['lowername'] . '/merit/"">Merit Table</a></li>
	                        <li><a href="' . $this->config->getUrl('base') . 'result/' . $division['lowername'] . '/league/"">League Table</a></li>
	                        <li><a href="' . $this->config->getUrl('base') . 'result/' . $division['lowername'] . '/fixture/"">Fixtures</a></li>
	                    </ul>
    				</div>
                </li>';
    	}
		$this->html .= '</ul>';
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