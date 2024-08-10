<?php

namespace Starlight\Database;

use Exception;
use mysqli;
use mysqli_result;

class SQL
{
    private MySQLi $sql;

    public function __construct($db_host, $db_user, $db_pass, $db_name)
    {
        try {
            $this->sql = new MySQLi(
                $db_host,
                $db_user,
                $db_pass,
                $db_name
            );
            $this->SQL->set_charset("utf8");
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function query(string $query): mysqli_result|bool
    {
        try {
            return $this->sql->query($query);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function escape(string $escape): string
    {
        try {
            return $this->sql->real_escape_string($escape);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
