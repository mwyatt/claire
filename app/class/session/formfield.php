<?php

namespace OriginalAppName\Session;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class FormField extends \OriginalAppName\Session
{


	protected $scope = 'OriginalAppName\Session\FormField';


	/**
	 * constantly builds a library of remembered fields
	 * these are overwritten when the field is submitted again
	 * @param array $structure  mainly $_POST, key->val
	 * @param array $fieldNames array of key to save, sometimes omitted
	 */
	public function add($structure, $fieldNames = array())
	{

		// resource
		$data = $this->getData();

		// loop through submitted key values
		foreach ($structure as $structureKey => $structureValue) {

			// if saving is required with submitted fields
			if ($fieldNames && in_array($structureKey, $fieldNames)) {
				$data[$structureKey] = $structureValue;
			}
		}
		return $this->setData($data);
	}
}
