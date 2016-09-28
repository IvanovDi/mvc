<?php

namespace core\models;

class ConnectionDB
{
    static private $_connection = null;

    private static function setConnection()
    {
        $conf = require __DIR__ . "/../configs/ConfigDB.php";
        $dsn = "{$conf['connection']}:host={$conf['host']};dbname={$conf['dbname']};";
        self::$_connection = new \PDO($dsn, $conf['user'], $conf['password']);
    }

    private function __construct()
    {

    }

    private function __sleep()
    {

    }

    private function __wakeup()
    {

    }

    private function __clone()
    {

    }

    static public function getConnection()
    {
        if (self::$_connection === null) {
            self::setConnection();
        }
        return self::$_connection;
    }
}