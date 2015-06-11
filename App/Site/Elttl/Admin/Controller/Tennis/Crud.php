<?php

namespace OriginalAppName\Site\Elttl\Admin\Controller\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Crud extends \OriginalAppName\Controller\Admin
{


	public $yearId;


	public $nameSingular;


	public $namePlural;


	public $nsEntity;


	public $model;


	public function __construct()
	{
		Parent::__construct();

		// naming vars and namespaces
		$registry = Registry::getInstance();
		$namespace = explode('\\', get_class($this));
		$this->nameSingular = strtolower(array_pop($namespace));
		$this->namePlural = $this->nameSingular . 's';
		$this->nsEntity = 'OriginalAppName\\Site\\Elttl\\Entity\\Tennis\\' . ucfirst($this->nameSingular);
		$class = 'OriginalAppName\\Site\\Elttl\\Model\\Tennis\\' . ucfirst($this->nameSingular);
		$this->model = new $class;
		$this->yearId = $registry->get('database/options/yearId');
		$this
			->view
			->appendAsset('js', 'admin/tennis/common')
			->setDataKey('nameSingular', $this->nameSingular)
			->setDataKey('namePlural', $this->namePlural)
			->setDataKey('urlCreate', $this->url->generate('admin/tennis/' . $this->nameSingular . '/create'));
	}


	public function create()
	{}


	public function all() {}


	public function single($id = 0)
	{}


	public function update($id)
	{}


	/**
	 * ajax because it is the only way i can do a delete request?
	 * @param  int $id 
	 * @return object     response
	 */
	public function delete($id)
	{}
}
