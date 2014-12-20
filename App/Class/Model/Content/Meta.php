<?php

namespace OriginalAppName\Model\Content;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Meta extends \OriginalAppName\Model
{	


	public $tableName = 'content_meta';


	public $fields = array(
		'id'
		, 'contentId'
		, 'name'
		, 'value'
	);


	public $entity = '\\OriginalAppName\\Entity\\Content\\Meta';


	/**
	 * accepts a valid name and filters out any entities which do not match
	 * @param  string $name 
	 * @return object         instance
	 */
	public function filterName($name)
	{
		if (! $this->getData()) {
			return $this;
		}
		$dataFiltered = array();
		foreach ($this->getData() as $entity) {
			if ($entity->getName() == $name) {
				$dataFiltered[] = $entity;
			}
		}
		$this->setData($dataFiltered);
		return $this;
	}
}
