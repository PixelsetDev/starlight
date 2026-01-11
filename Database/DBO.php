<?php

namespace Starlight\Database;

use PDO;
use PDOStatement;

/**
 * The database engine wrapper.
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
     * Create a PDO connection wrapped in DBO.
     * @param string $dsn PDO DSN string.
     * @param string|null $user Database username.
     * @param string|null $pass Database password.
     * @param array $pdoOptions Optional custom PDO options.
     * @return DBO
     */
    public static function connect(string $dsn, ?string $user = null, ?string $pass = null, array $pdoOptions = []): DBO
    {
        $defaults = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $pdo = new PDO($dsn, $user ?? '', $pass ?? '', $pdoOptions + $defaults);
        return new DBO($pdo);
    }

    /**
     * Runs a prepared SQL query.
     * @param string $sql SQL query with placeholders.
     * @param array $params Parameters to bind.
     * @return PDOStatement|bool
     */
    public function run(string $sql, array $params = []): PDOStatement|bool
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
        if ($stmt === true) return null;

        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    /**
     * Executes a query and returns a single scalar value.
     * @param string $sql
     * @param array $params
     * @return mixed|null
     */
    public function fetchValue(string $sql, array $params = []): mixed
    {
        $stmt = $this->run($sql, $params);
        if ($stmt === true) return null;

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
