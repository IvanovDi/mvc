<?php

require '../autoloader.php';

use \core\configs\Config;
use core\router\Router;

Config::set('applicationPath', __DIR__.'/../application');
Config::set('modulesPath', __DIR__.'/../modules/');
Config::set('viewPath', Config::get('applicationPath') . '/' . 'views/');
Config::set('moduleViewPath', Config::get('modulesPath') . 'user/views/');
Config::set('nameSpaceApp', '\\application\\controllers\\');
Config::set('nameSpaceModuleUser','\\modules\\user\\controllers\\');
Config::set('time_start', microtime());

$url = $_SERVER['REQUEST_URI'];

$router = new Router();
$router->parseUrl($url);
