<?php

namespace Starlight\Database;

use PDO;
use PDOStatement;

/**
 * The database connector. You may find it easier to use driver-specific classes.
 */
final class DBO
{
    /**
     * The underlying PDO connection.
     * @var PDO
     */
    private PDO $pdo;

    /**
     * Create a new DBO instance.
     * @param PDO $pdo A configured PDO connection instance.
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Runs a prepared SQL query safely.
     * @param string $sql    SQL query containing ? or :named placeholders.
     * @param array  $params Parameters to bind to the query.
     * @return PDOStatement|true
     */
    public function run(string $sql, array $params = []): PDOStatement|true
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        if ($stmt->columnCount() === 0) {
            return true;
        }

        return $stmt;
    }

    /**
     * Executes a query and returns all rows.
     * @param string $sql
     * @param array  $params
     * @return array<int, array<string, mixed>>
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->run($sql, $params);
        return $stmt === true ? [] : $stmt->fetchAll();
    }

    /**
     * Executes a query and returns the first row or null.
     * @param string $sql
     * @param array  $params
     * @return array<string, mixed>|null
     */
    public function fetchOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->run($sql, $params);
        if ($stmt === true) {
            return null;
        }

        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    /**
     * Executes a query and returns the first column of the first row. Useful for COUNT(*), EXISTS, SUM(), etc.
     * @param string $sql
     * @param array  $params
     * @return mixed|null
     */
    public function fetchValue(string $sql, array $params = []): mixed
    {
        $stmt = $this->run($sql, $params);
        if ($stmt === true) {
            return null;
        }

        $val = $stmt->fetchColumn(0);
        return $val === false ? null : $val;
    }

    /**
     * Returns the ID of the last inserted row.
     * @return string
     */
    public function lastInsertId(): string
    {
        return $this->pdo->lastInsertId();
    }
}
