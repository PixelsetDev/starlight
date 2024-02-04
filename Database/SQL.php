<?php

namespace Starlight\Database;

use mysqli;
use mysqli_result;

class SQL
{
    private MySQLi $SQL;

    public function __construct($db_host, $db_name, $db_user, $db_pass)
    {
        $this->SQL = new MySQLi(
            $db_host,
            $db_user,
            $db_pass,
            $db_name
        );
    }

    public function Query(string $Query): mysqli_result|bool
    {
        return $this->SQL->query($Query);
    }

    public function Escape(string $Escape): string
    {
        return $this->SQL->real_escape_string($Escape);
    }
}