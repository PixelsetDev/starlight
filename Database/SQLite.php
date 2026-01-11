<?php

namespace Starlight\Database;

use PDOStatement;

/**
 * The SQLite connector.
 */
final class SQLite
{
    /**
     * Internal database engine wrapper.
     * @var DBMS
     */
    private DBMS $DBMS;

    /**
     * Create a new SQLite instance.
     * @param string $db_path Path to SQLite database file.
     * @param array $pdoOptions Optional custom PDO options.
     */
    public function __construct(string $db_path, array $pdoOptions = [])
    {
        $dsn = sprintf('sqlite:%s', $db_path);
        $this->DBMS = DBMS::connect($dsn, null, null, $pdoOptions);
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
