<?php

namespace OriginalAppName;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 
class Data extends \OriginalAppName\System
{


	/**
	 * universal storage property, used for many things
	 * @var array
	 */
	public $data = [];


	/**
	 * @param mixed $value 
	 */
	public function setData($value)
	{		
		return $this->data = $value;
	}


	/**
	 * get
	 * @param  string $key [description]
	 * @return [type]      [description]
	 */
	public function getData($key = '')
	{		
		if ($key) {
			if (array_key_exists($key, $this->data)) {
				return $this->data[$key];
			}
			return;
		}
		return $this->data;
	}	


	/**
	 * retrieves the first row of data, if there is any
	 * @return object, array, bool       
	 */
	public function getDataFirst()
	{
		$data = $this->getData();
		if (! $data) {
			return;
		}
		return reset($data);
	}


	/**
	 * builds an array of {property} from the data property
	 * @param  string $property 
	 * @return array           
	 */
	public function getDataProperty($property)
	{
		if (! $data = $this->getData()) {
			return;
		}
		$method = 'get' . ucfirst($property);
		$dataSample = current($data);
		if (! method_exists($dataSample, $method)) {
			return;
		}
		$collection = [];
		foreach ($data as $entity) {
			$collection[] = $entity->$method();
		}
		return $collection;
	}


	/**
	 * append 1 to the data array
	 * @todo is this slow/ok?
	 * @param  any $dataRow 
	 * @return object          instance
	 */
	public function appendData($dataRow)
	{
		$data = $this->getData();
		$data[] = $dataRow;
		$this->setData($data);
		return $this;
	}


	public function limitData($range)
	{
		$data = $this->getData();
		$this->setData(array_slice($data, $range[0], $range[1]));
		return $this;
	}
}
