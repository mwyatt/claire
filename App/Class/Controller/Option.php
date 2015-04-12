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


	/**
	 * doctrine entity manger
	 * @var object
	 */
	public $entityManager;


	public function __construct()
	{
		parent::__construct();
		$this->databaseConnect();
		// $this->readOptions();
	}


	/**
	 * connect to db and store entity manager
	 * @return null 
	 */
	public function databaseConnect()
	{

		// get ent manager and connect to db
		$entityManager = include APP_PATH . 'database-connect' . EXT;

		// store
		$registry = Registry::getInstance();
		$registry->set('entityManager', $entityManager);
		$this->setEntityManager($entityManager);
	}


	/**
	 * @return object doctrine
	 */
	public function getEntityManager() {
	    return $this->entityManager;
	}
	
	
	/**
	 * @param object $entityManager Doctrine
	 */
	public function setEntityManager($entityManager) {
	    $this->entityManager = $entityManager;
	    return $this;
	}


	/**
	 * needs to be loaded for all controllers
	 * front, admin and ajax or any others
	 * @return null 
	 */
	public function readOptions()
	{
		$serviceOption = new OriginalAppName\Service\Option();
		$this
			->view
			->setDataKey('option', $serviceOption->read());
	}
}
