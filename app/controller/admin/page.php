<?php

/**
 * page
 *
 * PHP version 5
 * 
 * @access 9
 * @package	~unknown~
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

if (array_key_exists('form_page_new', $_POST)) {
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
	exit;
	
}

if ($config->getUrl(2) == 'new') {
	$view->loadTemplate('admin/page/new');
}
 
if ($config->getUrl(2))	$route->home('admin/page/');

$mainContent = new mainContent($database, $config);
$mainContent->readByType('page');

$view
	->setObject($mainContent)
	->loadTemplate('admin/page');
