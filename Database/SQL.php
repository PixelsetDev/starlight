<?php

namespace Starlight\Database;

use PDO;
use PDOStatement;

/**
 * The SQL connector.
 */
final class SQL
{
    /**
     * Internal database engine wrapper.
     * @var DBO
     */
    private DBO $dbo;

    /**
     * Create a new SQL instance.
     *
     * @param string $db_host Database host.
     * @param string $db_user Database username.
     * @param string $db_pass Database password.
     * @param string $db_name Database name.
     * @param int    $db_port Database port (default: 3306).
     * @param array  $pdoOptions Optional custom PDO options.
     */
    public function __construct(
        string $db_host,
        string $db_user,
        string $db_pass,
        string $db_name,
        int $db_port = 3306,
        array $pdoOptions = []
    ) {
        $dsn = $this->buildMysqlDsn($db_host, $db_name, $db_port);

        $defaults = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $pdo = new PDO($dsn, $db_user, $db_pass, $pdoOptions + $defaults);
        $this->dbo = new DBO($pdo);
    }

    /**
     * Builds a MySQL/MariaDB DSN string.
     *
     * @param string $host
     * @param string $dbName
     * @param int    $port
     *
     * @return string
     */
    private function buildMysqlDsn(string $host, string $dbName, int $port): string
    {
        return sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
            $host,
            $port,
            $dbName
        );
    }

    /**
     * Runs a prepared SQL query.
     * @param string $sql    SQL query with placeholders.
     * @param array  $params Parameters to bind.
     * @return PDOStatement|bool
     */
    public function run(string $sql, array $params = []): PDOStatement|bool
    {
        return $this->dbo->run($sql, $params);
    }

    /**
     * Executes a query and returns all rows.
     * @param string $sql
     * @param array  $params
     * @return array<int, array<string, mixed>>
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->dbo->fetchAll($sql, $params);
    }

    /**
     * Executes a query and returns the first row or null.
     * @param string $sql
     * @param array  $params
     * @return array<string, mixed>|null
     */
    public function fetchOne(string $sql, array $params = []): ?array
    {
        return $this->dbo->fetchOne($sql, $params);
    }

    /**
     * Executes a query and returns a single scalar value.
     * @param string $sql
     * @param array  $params
     * @return mixed|null
     */
    public function fetchValue(string $sql, array $params = []): mixed
    {
        return $this->dbo->fetchValue($sql, $params);
    }

    /**
     * Returns the ID of the last inserted row.
     * @return string
     */
    public function lastInsertId(): string
    {
        return $this->dbo->lastInsertId();
    }
}

