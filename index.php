<?php

define('PATH_BASE', (string) (__DIR__ . '/'));

include PATH_BASE . 'vendor/autoload.php';

try {
    $error = new \Mwyatt\Core\Error(PATH_BASE . 'error.txt');
    set_error_handler(array($error, 'handle'));
} catch (Exception $e) {
    exit($e->getMessage());
}

include PATH_BASE . 'pimple.php';

$config = $pimple['Config'];

if (!empty($config['errorReporting'])) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$router = $pimple['Router'];
$url = $pimple['Url'];
$urlPath = $url->getPath();
$view = $pimple['View'];
$request = $pimple['Request'];

$controllerDefault = new \Mwyatt\Claire\Controller($pimple, $view);

$menuPrimary = [
    (object) [
        'name' => 'Home',
        'url' => ''
    ],
    (object) [
        'name' => 'About me',
        'url' => 'page/about-me/'
    ]
];

$view->data->offsetSet('googleAnalyticsTrackingId', 'UA-43311305-1');
$view->data->offsetSet('menu', $menuPrimary);
$view->data->offsetSet('siteTitle', 'Claire Ruth');
$view->data->offsetSet('metaTitle', 'Claire\'s Blog');
$view->data->offsetSet('metaDescription', 'Bonjour. Je m’appelle Claire Louise Ruth. J’ai vingt ans. J’habite dans le nord-ouest de l’Angleterre. J’étudie le français et l’anglais à l’université à Warwick. J’aime la musique. J’aime les romans. J’aime les films. J’aime mes amis. J’aime ma famille.');

// divert attempted route if not logged in
$urlAdminBase = 'admin/';
if (strpos($urlPath, $urlAdminBase) === 0) {
    $userId = $request->getSession('admin.user');
    $view->data->offsetSet('adminUserId', $userId);
    if (!$userId && strlen($urlPath) > strlen($urlAdminBase)) {
        return $controllerDefault->redirect('admin.home');
    }
} else {
    $view->appendAsset('js', 'common.bundle');
    $view->appendAsset('css', 'common.bundle');
}

$route = $router->getMuxRouteCurrent($url->getPath());

if ($route) {
    $request->setMuxUrlVars($route);
    $controllerNs = $router->getMuxRouteCurrentController();
    $controllerMethod = $router->getMuxRouteCurrentControllerMethod();
    $controller = new $controllerNs($pimple, $view);
        
    try {
        $response = $controller->$controllerMethod($request);
    } catch (\Exception $e) {
        $response = $controllerDefault->serverError($e);
    }
} else {
    $response = $controllerDefault->notFound();
}

http_response_code($response->getStatusCode());
echo $response->getContent();
