<?php

namespace OriginalAppName\Site\Elttl\Entity\Tennis;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Encounter extends \OriginalAppName\Entity
{

	
	public $id;


	public $yearId;


	public $playerIdLeft;

	
	public $playerIdRight;

	
	public $scoreLeft;

	
	public $scoreRight;

	
	public $playerRankChangeLeft;

	
	public $playerRankChangeRight;


	public $fixtureId;

	
	/**
	 * possible values
	 * doubles
	 * exclude
	 * @var string
	 */
	public $status;
}
