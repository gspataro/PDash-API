<?php

/**
 * PDash API - PHP CRUD API for managing to do and notes
 * CLI installer
 *
 * @author Giuseppe Spataro <https://github.com/gspataro>
 * @version 1.0.0
 */

use GSpataro\Database;

if (php_sapi_name() !== 'cli') {
    die("Access granted only via CLI.");
}

require_once __DIR__ . "/source/directories.php";
require_once DIR_ROOT . "/config.php";
require_once DIR_VENDOR . "/autoload.php";

// Initialize database connection

$database = new Database\Connection(
    DB_DRIVER,
    DB_HOSTNAME,
    DB_USERNAME,
    DB_PASSWORD,
    DB_NAME,
    DB_PORT
);

$queriesQueue = [];

// Create todo table

$queriesQueue[] = $database->prepare("CREATE TABLE IF NOT EXISTS todo (
    id INT NOT NULL AUTO_INCREMENT,
    content VARCHAR(255),
    completed BOOLEAN,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)");

$queriesQueue[] = $database->prepare("CREATE TABLE IF NOT EXISTS notes (
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255),
    content LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
)");

// Execute queries

foreach ($queriesQueue as $query) {
    $query->execute();
}
