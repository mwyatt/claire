<?php

namespace OriginalAppName;


/**
 * @todo make this search class very high level
 */
class Search extends \OriginalAppName\Model
{


	public $tableName = 'content';


	public $entity = '\\OriginalAppName\\Entity\\Content';


	public $fields = array(
		'id',
		'title',
		'slug',
		'html',
		'type',
		'timePublished',
		'status',
		'userId'
	);


	public $query;


	public $queryArray;


	public $queryLimit = 20;


	/**
	 * map of scores to reward certain matches
	 * @var array
	 */
	public $scores = [
		'idFull' => 8,
		'skuFull' => 7,
		'skuKeyword' => 6,
		'titleFull' => 6,
		'titleKeyword' => 5,
		'summaryFull' => 5,
		'summaryKeyword' => 4
	];


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


	public function begin($query)
	{
		$this->validateQuery($query);
		$this->bigQuery();
	}


	public function getSqlIf($config)
	{
		$sql = [];
		$sql[] = "if (" . $config['column'] . " like '%";
		$sql[] = $config['term'];
		$sql[] = "%', " . $this->getScore($config['keyScore']) . ", 0)";
        return implode('', $sql);
	}


	public function bigQuery()
	{
		$sql = [
			'id' => [],
			'sku' => [],
			'title' => [],
			'summary' => []
		];

		// full match
	    if (count($this->getQueryArray()) > 1){
	        $sql['id'][] = $this->getSqlIf([
	        	'term' => $this->getQuery(),
	        	'column' => 'id',
	        	'keyScore' => 'titleFull'
        	]);
	        $sql['sku'][] = $this->getSqlIf([
	        	'term' => $this->getQuery(),
	        	'column' => 'sku',
	        	'keyScore' => 'skuFull'
        	]);
	        $sql['title'][] = $this->getSqlIf([
	        	'term' => $this->getQuery(),
	        	'column' => 'name',
	        	'keyScore' => 'titleFull'
        	]);
	        $sql['summary'][] = $this->getSqlIf([
	        	'term' => $this->getQuery(),
	        	'column' => 'keywords',
	        	'keyScore' => 'summaryFull'
        	]);
	    }

	    // keyword match
	    foreach ($this->getQueryArray() as $word) {
	        $sql['sku'][] = $this->getSqlIf([
	        	'term' => $word,
	        	'column' => 'sku',
	        	'keyScore' => 'skuKeyword'
        	]);
	        $sql['title'][] = $this->getSqlIf([
	        	'term' => $word,
	        	'column' => 'name',
	        	'keyScore' => 'titleKeyword'
        	]);
	        $sql['summary'][] = $this->getSqlIf([
	        	'term' => $word,
	        	'column' => 'keywords',
	        	'keyScore' => 'summaryKeyword'
        	]);
	    }


		$sql = "
			select
				id,
				name,
				keywords
	            (
	                (-- id
	                " . implode(" + ", $sql['id']) . "
	                )+
	                (-- title
	                " . implode(" + ", $sql['title']) . "
	                )+
	                (-- summary
	                " . implode(" + ", $sql['summary']) . " 
	                )
	            ) as relevance
            from " . $this->getTableName() . "
            where p.status = 'published'
            having relevance > 0
            order by relevance desc
            limit 100
        ";



		// query
		$sth = $this->database->dbh->prepare("
			{$this->getSqlSelect()}
            where type = :type
		");

		// mode
		$sth->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());

		// bind
	    $sth->bindValue(':type', $type, \PDO::PARAM_STR);

	    // execute
		$sth->execute();

		// fetch
		$this->setData($sth->fetchAll());

		// instance
		return $this;
	}


	/**
	 * limits and strips out dull words
	 * @param  string $query 
	 * @return object        
	 */
	public function validateQuery($query)
	{
		$this->setQuery($this->getLimitedQuery($query));
		foreach ($this->getQueryArray() as $key => $word) {
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
	 * @param array $scores 
	 */
	public function setScores($scores) {
	    $this->scores = $scores;
	    return $this;
	}


	/**
	 * get a single score
	 * @param  string $key 
	 * @return int      
	 */
	public function getScore($key)
	{
		$scores = $this->getScores();
		if (isset($scores[$key])) {
			return $scores[$key];
		}
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
