<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Archive extends Controller_Index
{


	public function run()
	{

		// result/premier/
		if ($this->url->getPathPart(2)) {
			$this->division();
		} else {
			$this->divisionList();
		}
	}


	public function divisionList()
	{

		$modelTennisDivision = new model_tennis_division($this);
		$modelTennisDivision->read();
		
		// template
		$this->view
			->setMeta(array(		
				'title' => 'Divisions'
			))
			->setObject('divisions', $modelTennisDivision->getData())
			->getTemplate('division/list');
	}
}
