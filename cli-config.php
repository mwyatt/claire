<?php

// dependencies
include 'constant.php';
include BASE_PATH . 'vendor' . DS . 'autoload' . EXT;

// connect
include APP_PATH . 'database-connect' . EXT;

// cmd
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
