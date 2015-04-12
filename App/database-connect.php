<?php

// dependencies
$credentials = include SITE_PATH . 'credentials' . EXT;
$configApp = include APP_PATH . 'config' . EXT;
$configSite = include SITE_PATH . 'config' . EXT;

// configure
$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($configSite['doctrine/entity/path'], $configApp['doctrine/devMode']);

// connect
return $entityManager = \Doctrine\ORM\EntityManager::create($credentials, $config);
