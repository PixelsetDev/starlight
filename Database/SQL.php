<?php

namespace Starlight\Database;

use Exception;
use mysqli;
use mysqli_result;

class SQL
{
    private MySQLi $SQL;

    public function __construct($db_host, $db_user, $db_pass, $db_name)
    {
        try {
            $this->SQL = new MySQLi(
                $db_host,
                $db_user,
                $db_pass,
                $db_name
            );
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function Query(string $Query): mysqli_result|bool
    {
        try {
            return $this->SQL->query($Query);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function Escape(string $Escape): string
    {
        try {
            return $this->SQL->real_escape_string($Escape);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
}