<?php

use DI\Bridge\Slim\Bridge;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

// Init app
$container = new Container();
$app = Bridge::create($container);

// Dependencies
$container->set('db', fn() => new PDO("sqlite:../database/database.sqlite"));

// Routes
$routes = include __DIR__ . '/../src/routes.php';
$routes($app);

// Start!
$app->run();