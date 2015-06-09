<?php

namespace OriginalAppName\Controller;

use OriginalAppName\Registry;
use OriginalAppName;


/**
 * Controller
 * only file which starts at beginning of front and admin contollers
 * only safe place to connect to db?
 * bad place to init the db, but where else?
 * 
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Option extends \OriginalAppName\Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->readOptions();
	}


	/**
	 * needs to be loaded for all controllers
	 * front, admin and ajax or any others
	 * @return null 
	 */
	public function readOptions()
	{
		$registry = Registry::getInstance();
		$serviceOption = new OriginalAppName\Service\Option();
		$options = $serviceOption->read();
		$registry->set('database/options', $options);
		$this
			->storeYearId()
			->view
			->setDataKey('option', $serviceOption->getData());
	}


	public function storeYearId()
	{
		$registry = Registry::getInstance();
		foreach ($registry->get('database/options') as $name => $entity) {
			if ($name == 'year_id') {
				$registry->set('database/options/yearId', $entity->value);
			}
		}
		return $this;
	}
}
