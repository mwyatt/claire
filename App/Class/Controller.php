<?php

namespace OriginalAppName;


/**
 * @author Martin Wyatt <martin.wyatt@gmail.com>
 * @version     0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Controller
{


    public $view;


    public $url;


    public function __construct()
    {
        $registry = \OriginalAppName\Registry::getInstance();
        $this
            ->setUrl($registry->get('url'))
            ->setView(new \OriginalAppName\View);
    }


    public function error500($exception)
    {
        $this->view->setDataKey('exceptionMessage', $exception->getMessage());
        return new \OriginalAppName\Response($this->view->getTemplate('500'), 500);
    }


    /**
     * @return object
     */
    public function getView()
    {
        return $this->view;
    }
    
    
    /**
     * @param object $view
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }


    /**
     * redirects the user to another url and terminates
     * utilising the generator from symfony
     * could this be a static function?
     * @param  string $key      routeKey
     * @param  array $config if required
     * @return null
     */
    public function redirect($key, $config = [])
    {

        // get url from registry and generate string
        $registry = \OriginalAppName\Registry::getInstance();
        $url = $registry->get('url');
        $url = $url->generate($key, $config);

        // redirect
        header('location:' . $url);

        // prevent continuation
        exit;
    }


    public function redirectAbsolute($url)
    {

        // route
        header('location:' . $url);

        // prevent continuation
        exit;
    }


    /**
     * @return object
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    
    /**
     * @param object $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
}
