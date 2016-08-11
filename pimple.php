<?php

$pimple = new \Pimple\Container;

$pimple['Routes'] = function () {
    return include PATH_BASE . 'routes.php';
};

$pimple['Router'] = function ($pimple) {
    $router = new \Mwyatt\Core\Router(new \Pux\Mux);
    $router->appendMuxRoutes($pimple['Routes']);
    return $router;
};

$pimple['Request'] = function ($pimple) {
    session_start();
    return new \Mwyatt\Core\Request;
};

$pimple['View'] = function ($pimple) {
    $view = new \Mwyatt\Core\View;
    $view->setPathBase(PATH_BASE);
    $view->prependTemplatePath($view->getPathBase('template/'));
    $view->data->offsetSet('url', $pimple['Url']);
    return $view;
};

$pimple['Config'] = function () {
    return include PATH_BASE . 'config.php';
};

$pimple['Url'] = function ($pimple) {
    $router = $pimple['Router'];
    $request = $pimple['Request'];
    $config = $pimple['Config'];
    $url = new \Mwyatt\Core\Url($request->getServer('HTTP_HOST'), $request->getServer('REQUEST_URI'), $config['urlBase']);
    $url->setRoutes($router->getMux());
    return $url;
};

$pimple['Markdown'] = function ($pimple) {
    return new \Michelf\Markdown;
};

$pimple['Post'] = function ($pimple) {
    return new \Mwyatt\Claire\Service\Post($pimple['MapperFactory'], $pimple['ModelFactory']);
};

$pimple['Database'] = function ($pimple) {
    $config = $pimple['Config'];
    $database = new \Mwyatt\Core\Database\Pdo;
    $database->connect([
        'host' => $config['db.host'],
        'basename' => $config['db.basename'],
        'username' => $config['db.username'],
        'password' => $config['db.password']
    ]);
    return $database;
};

$pimple['ModelFactory'] = function ($pimple) {
    $modelFactory = new \Mwyatt\Core\ModelFactory;
    $modelFactory->setDefaultNamespace('\\Mwyatt\\Claire\\Model\\');
    return $modelFactory;
};

$pimple['MapperFactory'] = function ($pimple) {
    $mapperFactory = new \Mwyatt\Core\MapperFactory($pimple['Database'], $pimple['ModelFactory']);
    $mapperFactory->setDefaultNamespace('\\Mwyatt\\Claire\\Mapper\\');
    return $mapperFactory;
};
