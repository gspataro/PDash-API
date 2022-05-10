<?php

use GSpataro\Routing;
use GSpataro\Database;

require_once __DIR__ . "/directories.php";
require_once DIR_ROOT . "/config.php";
require_once DIR_VENDOR . "/autoload.php";

// Initialize filp/whoops error handler

$whoopsHandler = new Whoops\Handler\PrettyPageHandler();
$whoops = new Whoops\Run();
$whoops->pushHandler($whoopsHandler);
$whoops->register();

// Initialize database connection

$db = new Database\Connection(
    DB_DRIVER,
    DB_HOSTNAME,
    DB_USERNAME,
    DB_PASSWORD,
    DB_NAME
);

$request = new Routing\Request();
$router = new Routing\Router();
