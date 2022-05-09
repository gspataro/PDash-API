<?php

use GSpataro\Routing;
use GSpataro\Database;

require_once __DIR__ . "/directories.php";

// Initialize database connection

$db = new Database\Connection(
    "mysql",
    "localhost",
    "root",
    "root",
    "ahhahahah"
);

$request = new Routing\Request();
$router = new Routing\Router();
