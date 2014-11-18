<?php

namespace OriginalAppName;


$search
	->setTableName('shop_products')
	->setScores([
		'id' => ['full' => 8],
		'sku' => ['full' => 7, 'part' => 6],
		'name' => ['full' => 6, 'part' => 5],
		'status' => [],
		'keywords' => ['full' => 5, 'part' => 4]
	])
	->begin($_REQUEST['query']);



/**
 * @todo untested in the mvc scope
 */
class Search extends \OriginalAppName\Model
{


	public $tableName;


	public $entity = '\\OriginalAppName\\Entity\\Content';


	public $fields;


	public $query;


	public $queryLimit = 20;


	public $dataLimit = 100;


	/**
	 * maps out scores for each column for full and part matches
	 * @var array multidimensional
	 */
	public $scores;


	/**
	 * words nobody cares about, not even this class
	 * @var array
	 */
	public $dullWords = [
		'in',
		'it',
		'a',
		'the',
		'of',
		'or',
		'I',
		'you',
		'he',
		'me',
		'us',
		'they',
		'she',
		'to',
		'but',
		'that',
		'this',
		'those',
		'then'
	];


	public function begin($query = '')
	{
		if (! $query) {
			return $this;
		}
		$this->validateQuery($query);
		$this->executeQuery();
		$this->createLog();
		return $this;
	}


	public function executeQuery()
	{
		$this->setData($this->db->get_all_rows($this->db->query($this->getSql())));
	}


	public function getSqlIf($config)
	{
		$sql = [];
		$sql[] = "if (" . $config['column'] . " like '%";
		$sql[] = $config['term'];
		$sql[] = "%', " . $config['score'] . ", 0)";
        return implode('', $sql);
	}


	public function getSqlColumn($column)
	{
		$sql = [];

		// full
	    if ($this->getScore($column, 'full')) {
	        $sql[] = $this->getSqlIf([
	        	'term' => $this->getQuery(),
	        	'column' => $column,
	        	'score' => $this->getScore($column, 'full')
        	]);
		}

		// part
		if ($this->getScore($column, 'part')) {
		    foreach ($this->getQueryArray() as $word) {
		        $sql[] = $this->getSqlIf([
		        	'term' => $word,
		        	'column' => $column,
		        	'score' => $this->getScore($column, 'part')
	        	]);
		    }
		}

		// sql
		return $sql;
	}


	public function getSql()
	{
		$sql = [];
		$sql[] = 'select';
		$sql[] = $this->getSqlFields();
		$sql[] = ',';

		// relevance
		$sql[] = '(';
		$sqlRelevance = [];
		foreach ($this->getFields() as $column) {
			$sqlColumn = $this->getSqlColumn($column);
			if ($sqlColumn) {
				$sqlRelevance[] = '(' . implode(' + ', $sqlColumn) . ')';
			}
		}
		$sql[] = implode('+', $sqlRelevance);
		$sql[] = ') as relevance';
		
		// from
		$sql[] = 'from';
		$sql[] = $this->getTableName();

		// where
		$sql[] = "where status != '" . Inventory_Product_Status::HIDDEN . "'";
		$sql[] = "having relevance > 0";

		// order / limit
        $sql[] = 'order by relevance desc';
        $sql[] = 'limit ' . $this->getDataLimit();

        // concat
		return implode(' ', $sql);
	}


	/**
	 * limits and strips out dull words
	 * @param  string $query 
	 * @return object        
	 */
	public function validateQuery($query)
	{
		$query = mysql_real_escape_string($query);
		$this->setQuery($this->getLimitedQuery($query));
		$words = $this->getQueryArray();
		foreach ($words as $key => $word) {
			if (in_array($word, $this->getDullWords())) {
				unset($words[$key]);
			}
		}
		return $this->setQuery(implode(' ', $words));
	}


	/**
	 * @return array 
	 */
	public function getQueryArray() {
	    return explode(' ', $this->getQuery());
	}


	/**
	 * limits the query and sets it
	 * @param string $query 
	 */
	public function getLimitedQuery($query)
	{
	    return substr($query, 0, $this->getQueryLimit());
	}


	/**
	 * @return array 
	 */
	public function getQuery() {
	    return $this->query;
	}
	
	
	/**
	 * @param array $query 
	 */
	public function setQuery($query) {
	    $this->query = $query;
	    return $this;
	}


	/**
	 * @return int 
	 */
	public function getQueryLimit() {
	    return $this->queryLimit;
	}
	
	
	/**
	 * @param int $queryLimit 
	 */
	public function setQueryLimit($queryLimit) {
	    $this->queryLimit = $queryLimit;
	    return $this;
	}


	/**
	 * @return array 
	 */
	public function getScores() {
	    return $this->scores;
	}
	
	
	/**
	 * store keys as fields list
	 * @param array $scores 
	 */
	public function setScores($scores) {
		$this->setFields(array_keys($scores));
	    $this->scores = $scores;
	    return $this;
	}


	/**
	 * @param array $fields 
	 */
	public function setFields($fields) {
	    $this->fields = $fields;
	    return $this;
	}


	/**
	 * get a single score
	 * @param  string $key 
	 * @return int      
	 */
	public function getScore($column, $size)
	{
		$scores = $this->getScores();
		if (! isset($scores[$column])) {
			return;
		}
		if (! isset($scores[$column][$size])) {
			return;
		}
		return $scores[$column][$size];
	}


	/**
	 * @return array 
	 */
	public function getDullWords() {
	    return $this->dullWords;
	}
	
	
	/**
	 * @param array $dullWords 
	 */
	public function setDullWords($dullWords) {
	    $this->dullWords = $dullWords;
	    return $this;
	}
}
