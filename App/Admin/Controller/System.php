<?php

namespace OriginalAppName\Admin\Controller;

use OriginalAppName;
use OriginalAppName\Response;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class System extends \OriginalAppName\Controller\Admin
{


	/**
	 * @return object Response
	 */
	public function upgradeAll() {
		$files = glob(APP_PATH . 'sql' . DS . 'patch' . DS . '*.sql');
		foreach ($files as $file) {
			
		}
echo '<pre>';
print_r($files);
echo '</pre>';
exit;


		foreach ($folder as $filePath) {
			$filePath = str_replace(BASE_PATH, '', $filePath);
			$files[] = str_replace(DS, US, $filePath);
		}

		
/*

when loading module compare all installed versions to versions found in folder
place remainder in date / numerical order
'upgrade db'
	each file is loaded and executed, on success row added to db
patches could be global or site specific so both need to be checked and patched in order?

table
	all rows represent a successful patch
systemVersion
	id
	version
	timePatched
	userId


 */



		// glob(pattern)

		// get options
		// $options = $this->view->getData('option');

		// render
		$this
			->view
			->setDataKey('moduleName', 'option/all')
			->setDataKey('options', $options);
		return new Response($this->view->getTemplate('admin/option/all'));
	}
}
