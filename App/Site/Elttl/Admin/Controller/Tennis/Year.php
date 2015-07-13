<?php
namespace OriginalAppName\Site\Elttl\Admin\Controller\Tennis;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version	0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Year extends \OriginalAppName\Controller\Admin
{


	public function all() {
		$modelYear = new \OriginalAppName\Site\Elttl\Model\Tennis\Year;
		$modelYear->read();

		// current
		$registry = \OriginalAppName\Registry::getInstance();

		// render
		$this
			->view
			->setDataKey('currentYearId', $registry->get('database/options/yearId'))
			->setDataKey('years', $modelYear->getData());
		return new \OriginalAppName\Response($this->view->getTemplate('admin/tennis/year/all'));
	}
}
