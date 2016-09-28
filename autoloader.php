<?php
spl_autoload_register(function ($class) {
    $arr = explode("\\", $class);
    $res =  __DIR__ . "/" . implode('/', $arr).'.php';
    require $res;
});