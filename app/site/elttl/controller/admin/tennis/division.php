<?php


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller_Admin_Tennis_Division extends Controller_Admin
{


	public function run()
	{
		$this->read();
	}


	/**
	 * get list of all
	 * @return null 
	 */
	public function read()
	{

		// divisions
		$modelTennisDivision = new model_tennis_Division($this);
		$modelTennisDivision
			->read()
			->orderByPropertyIntDesc('id');

		// template
		$this->view
			->setObject('divisions', $modelTennisDivision->getData())
			->getTemplate('admin/tennis/division/list');
	}
}
