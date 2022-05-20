<?php

use GSpataro\Routing;
use GSpataro\Database;
use GSpataro\Validation;

require_once __DIR__ . "/directories.php";
require_once DIR_ROOT . "/config.php";
require_once DIR_VENDOR . "/autoload.php";

// Initialize filp/whoops error handler

$whoopsHandler = new Whoops\Handler\JsonResponseHandler();
$whoops = new Whoops\Run();
$whoops->pushHandler($whoopsHandler);
$whoops->register();

// Initialize database connection

$db = new Database\Connection(
    DB_DRIVER,
    DB_HOSTNAME,
    DB_USERNAME,
    DB_PASSWORD,
    DB_NAME,
    DB_PORT
);

// Initialize validation module

Validation\Validator::loadDefaultRules();

// Initialize routing process

$request = new Routing\Request();
$routesCollection = new Routing\RoutesCollection();

$routes = require_once DIR_APP . "/routes.php";
$routesCollection->feed($routes);

$router = new Routing\Router(
    $routesCollection,
    $request
);
$response = $router->deploy();

// Dispatch response route

$controller = new $response->matchingRoute['controller'](
    $request,
    $response,
    $db
);
call_user_func([$controller, $response->matchingRoute['method']]);
