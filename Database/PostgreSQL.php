<?php

namespace Starlight\Database;

use PDOStatement;

/**
 * The PostgreSQL connector.
 */
final class PostgreSQL
{
    /**
     * Internal database engine wrapper.
     * @var DBMS
     */
    private DBMS $DBMS;

    /**
     * Create a new PostgreSQL instance.
     * @param string $db_host Database host.
     * @param string $db_user Database username.
     * @param string $db_pass Database password.
     * @param string $db_name Database name.
     * @param int $db_port Database port (default: 5432).
     * @param array $pdoOptions Optional custom PDO options.
     */
    public function __construct(
        string $db_host,
        string $db_user,
        string $db_pass,
        string $db_name,
        int $db_port = 5432,
        array $pdoOptions = []
    ) {
        $dsn = sprintf('pgsql:host=%s;port=%d;dbname=%s', $db_host, $db_port, $db_name);
        $this->DBMS = DBMS::connect($dsn, $db_user, $db_pass, $pdoOptions);
    }

    /** @see DBMS::run() */
    public function run(string $sql, array $params = []): PDOStatement|bool
    {
        return $this->DBMS->run($sql, $params);
    }

    /** @see DBMS::fetchAll() */
    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->DBMS->fetchAll($sql, $params);
    }

    /** @see DBMS::fetchOne() */
    public function fetchOne(string $sql, array $params = []): ?array
    {
        return $this->DBMS->fetchOne($sql, $params);
    }

    /** @see DBMS::fetchValue() */
    public function fetchValue(string $sql, array $params = []): mixed
    {
        return $this->DBMS->fetchValue($sql, $params);
    }

    /** @see DBMS::lastInsertId() */
    public function lastInsertId(): string
    {
        return $this->DBMS->lastInsertId();
    }

    /** @see DBMS::numRows() */
    public function numRows(): int
    {
        return $this->DBMS->numRows();
    }
}
