<?php

namespace OriginalAppName\Entity;


/**
 * @Entity @Table(name="ad")
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Ad extends \OriginalAppName\Entity
{


	/**
     * @Id @GeneratedValue @Column(type="integer")
	 * @var int
	 */
	protected $id;


	/**
     * @Column(type="string")
	 * @var string
	 */
	private $title;


	/**
     * @Column(type="string")
	 * @var string
	 */
	private $description;


	/**
	 * relative url to featured image / artwork
     * @Column(type="string")
	 * @var string
	 */
	private $image;

	
	/**
	 * relative pointer to content
     * @Column(type="string")
	 * @var string
	 */
	private $url;


	/**
	 * button which does something to confirm
     * @Column(type="string", length=50)
	 * @var string
	 */
	private $action;


	/**
	 * ties together ads
     * @Column(type="string", length=50)
	 * @var string
	 */
	private $group;
}
