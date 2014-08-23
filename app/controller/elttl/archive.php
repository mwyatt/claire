<?php


/**
 * functionaliy for other controllers to inherit
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Archive extends Controller_Index
{


	public $year;


	public function run()
	{
		echo '<pre>';
		print_r('Controller_Archive');
		echo '</pre>';
		exit;
		
	}
	

	/**
	 * @return int 
	 */
	public function getYear() {
	    return $this->year;
	}
	
	
	/**
	 * @param int $year 
	 */
	public function setYear($year) {
	    $this->year = $year;
	    return $this;
	}


	public function readYear()
	{
		if ($this->url->getPathPart(0) != 'archive') {
			return;
		}
		$modelTennisYear = new model_tennis_Year($this);
		$modelTennisYear->read(array(
			'where' => array('name' => $this->url->getPathPart(1))
		));
		if (! $year = $modelTennisYear->getDataFirst()) {
			return;
		}
		$this->setYear($year);
	}


	/**
	 * translates url structure for archive
	 * @param  int $key 
	 * @return string      
	 */
	public function getArchivePathPart($key)
	{
		$modifier = 2;
		if ($this->getYear()) {
			return $this->url->getPathPart($key + $modifier);
		}
		return $this->url->getPathPart($key);
	}


	/**
	 * intercept sql where construct and adds year id
	 * @param  array  $sqlArray 
	 * @return array           
	 */
	public function getArchiveWhere($sqlArray = array())
	{

		// not archived
		if (! $year = $this->getYear()) {
			return $sqlArray;
		}

		// no where so build query
		if (! array_key_exists('where', $sqlArray)) {
			return array(
				'where' => array('year_id' => $year->getId())
			);
		}

		// where to add to query
		$sqlArray['where']['year_id'] = $year->getId();
		return $sqlArray;
	}


	/**
	 * creates class name based on whether archived or not
	 * @param  string $className 
	 * @return string            
	 */
	public function getArchiveClassName($className)
	{
		$modifier = 'archive_';
		if ($this->getYear()) {
			return str_replace('model_', 'model_' . $modifier, $className);
		}
		return $className;
	}
}
