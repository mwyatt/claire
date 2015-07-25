<?php

namespace OriginalAppName\Site\Elttl\Controller;

/**
 * remove
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Front extends \OriginalAppName\Controller\Front
{


    public $year;


    public function __construct()
    {
        parent::__construct();
        $this->readYear();
    }


    public function readYear()
    {
    	$registry = \OriginalAppName\Registry::getInstance();
    	$modelYear = new \OriginalAppName\Site\Elttl\Model\Tennis\Year;
    	$modelYear->readId([$registry->get('database/options/yearId')]);
    	$this->view->setDataKey('year', $modelYear->getDataFirst());
    	$this->year = $modelYear->getDataFirst();
    }
}
