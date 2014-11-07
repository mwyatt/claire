<?php

namespace OriginalAppName\Entity;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Content_Meta extends OriginalAppName\Entity\Meta
{


	private $contentId;	


	/**
	 * @return inst 
	 */
	public function getContentId() {
	    return $this->contentId;
	}
	
	
	/**
	 * @param inst $contentId 
	 */
	public function setContentId($contentId) {
	    $this->contentId = $contentId;
	    return $this;
	}
}
