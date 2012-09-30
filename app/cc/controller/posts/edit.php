<?php

/**
 * @package	~unknown~
 * @author 	Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */ 


$posts = new ccContent($DBH, 'post');
$posts
	->select(1, $_GET['edit']);


// View: posts-edit
// -----------------------------------------------------------------------------
require_once('app/cc/view/posts-edit.php');
exit;