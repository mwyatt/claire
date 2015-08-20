<?php

namespace OriginalAppName\Controller;

/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Index extends \OriginalAppName\Controller\Front
{


    public function home()
    {
        return new \OriginalAppName\Response($this->view->getTemplate('home'));
    }
}
