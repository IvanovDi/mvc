<?php

namespace core\configs;

class Config
{
    private static $_data = [];
    private function __construct()
    {

    }
    private function __sleep()
    {

    }
    private function __wakeup()
    {

    }
    public static function get($key, $value = null)
    {
        return self::$_data[$key];
    }
    static public function set($key, $value)
    {
        self::$_data[$key] = $value;
    }
    static public function getAll()
    {
         return self::$_data;
    }
}