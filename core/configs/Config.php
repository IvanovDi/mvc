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
    //@todo __clone() private
    public static function get($key, $value = null)
    {
        return self::$_data[$key];//@todo проверка
    }
    static public function set($key, $value)
    {
        self::$_data[$key] = $value;//@todo проверка что бы не перезаписывать
    }
    static public function getAll()//@todo не нужен
    {
         return self::$_data;
    }
}