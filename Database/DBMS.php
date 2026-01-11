<?php

namespace Starlight\Database;

use PDO;
use PDOStatement;

/**
 * The database engine wrapper.
 */
final class DBMS
{
    /**
     * The underlying PDO connection.
     * @var PDO
     */
    private PDO $pdo;

    /**
     * Last executed query.
     * @var array{sql: string|null, params: array, affected_rows: int|null}
     */
    private array $last = [
        'sql' => null,
        'params' => [],
        'affected_rows' => null,
    ];

    /**
     * Create a new DBMS instance.
     * @param PDO $pdo A configured PDO connection instance.
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Create a PDO connection wrapped in DBMS.
     * @param string $dsn PDO DSN string.
     * @param string|null $user Database username.
     * @param string|null $pass Database password.
     * @param array $pdoOptions Optional custom PDO options.
     * @return DBMS
     */
    public static function connect(string $dsn, ?string $user = null, ?string $pass = null, array $pdoOptions = []): DBMS
    {
        $defaults = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $pdo = new PDO($dsn, $user ?? '', $pass ?? '', $pdoOptions + $defaults);
        return new DBMS($pdo);
    }

    /**
     * Runs a prepared SQL query.
     * @param string $sql SQL query with placeholders.
     * @param array $params Parameters to bind.
     * @return PDOStatement
     */
    public function run(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        if ($stmt->columnCount() !== 0) {
            $this->last['sql'] = $sql;
            $this->last['params'] = $params;
            $this->last['affected_rows'] = null;
        } else {
            $this->last['sql'] = null;
            $this->last['params'] = [];
            $this->last['affected_rows'] = $stmt->rowCount();
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
        return $this->run($sql, $params)->fetchAll();
    }

    /**
     * Executes a query and returns the first row or null.
     * @param string $sql
     * @param array  $params
     * @return array<string, mixed>|null
     */
    public function fetchOne(string $sql, array $params = []): ?array
    {
        $row = $this->run($sql, $params)->fetch();
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
        $val = $this->run($sql, $params)->fetchColumn(0);
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

    /**
     * Returns the number of rows for the last query.
     * - If last query was SELECT-like: returns total rows (COUNT wrapper).
     * - If last query was non-SELECT: returns affected rows.
     * @return int
     */
    public function numRows(): int
    {
        // Non-SELECT last query: return affected rows.
        if ($this->last['sql'] === null) {
            if ($this->last['affected_rows'] !== null) {
                return $this->last['affected_rows'];
            }
            throw new \RuntimeException('numRows() called before any query.');
        }

        $sql = preg_replace('/\s+ORDER\s+BY\s+[\s\S]*$/iu', '', $this->last['sql']) ?? $this->last['sql'];

        $countSql = "SELECT COUNT(*) FROM ({$sql}) AS _count_wrapper";
        $stmt = $this->pdo->prepare($countSql);
        $stmt->execute($this->last['params']);

        return (int) $stmt->fetchColumn();
    }
}
