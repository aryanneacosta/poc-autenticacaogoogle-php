<?php

namespace app\database;

use PDO;

class Connect
{
    public static function connect()
    {
        return new PDO(dsn:'pgsql:host=localhost;port=5432;dbname=poc-php', username:'postgres', password:'', options: [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ]);
    }
}