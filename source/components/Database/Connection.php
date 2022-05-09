<?php

namespace GSpataro\Database;

use PDO;
use PDOException;

final class Connection
{
    /**
     * Store connection
     *
     * @var PDO
     */

    private PDO $pdo;

    /**
     * Initialize database connection
     *
     * @param string $driver
     * @param string $hostname
     * @param string $username
     * @param string $password
     * @param string $dbname
     * @param int $port
     */

    public function __construct(string $driver, string $hostname, string $username, string $password, string $dbname, int $port = 3306)
    {
        $dsn = "{$driver}:host={$hostname};port={$port};dbname={$dbname}";

        try {
            $this->pdo = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    /**
     * Get connection
     *
     * @return PDO
     */

    public function get(): PDO
    {
        return $this->pdo;
    }
}
