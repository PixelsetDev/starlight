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
     * @var DBO
     */
    private DBO $dbo;

    /**
     * Create a new SQLite instance.
     * @param string $db_path Path to SQLite database file.
     * @param array $pdoOptions Optional custom PDO options.
     */
    public function __construct(string $db_path, array $pdoOptions = [])
    {
        $dsn = sprintf('sqlite:%s', $db_path);
        $this->dbo = DBO::connect($dsn, null, null, $pdoOptions);
    }

    /** @see DBO::run() */
    public function run(string $sql, array $params = []): PDOStatement|bool
    {
        return $this->dbo->run($sql, $params);
    }

    /** @see DBO::fetchAll() */
    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->dbo->fetchAll($sql, $params);
    }

    /** @see DBO::fetchOne() */
    public function fetchOne(string $sql, array $params = []): ?array
    {
        return $this->dbo->fetchOne($sql, $params);
    }

    /** @see DBO::fetchValue() */
    public function fetchValue(string $sql, array $params = []): mixed
    {
        return $this->dbo->fetchValue($sql, $params);
    }

    /** @see DBO::lastInsertId() */
    public function lastInsertId(): string
    {
        return $this->dbo->lastInsertId();
    }
}
