<?php

namespace core\router;

use \core\configs\Config;
use \modules\user\controllers\TestController;

class Router
{
    protected function callController($url, $controller = 'def', $action = 'index', $module = null)
    {
        $controller = ucfirst($controller) . 'Controller';
        $action = "action" . ucfirst($action);
        if($module === null) {
            $controllerClass = Config::get('nameSpaceApp') . $controller;
        } else {
            $controllerClass = Config::get('nameSpaceModuleUser') . $controller;
        }
        $controller = new  $controllerClass();
        if (method_exists($controller, $action)) {
            if($param = $this->parseParam($url, $controller, $action)) {
                call_user_func_array(array($controller, $action), $param);
            } else {
                echo 'not enough parameters';
            }
        } else {
            echo 'No exist call method';
        }
    }

    protected function parseParam($data, $controller, $action)//
    {
        if($data !== null) {
            parse_str($data, $param);
        }
        $trueParam = new \ReflectionMethod($controller, $action);
        $trueParam = $trueParam->getParameters();
        $count = count($trueParam);
        $arrKey = array_keys($param);
        for($i = 0; $i < $count; $i++) {
            for($j = 0; $j < $count; $j++) {
                if($arrKey[$i] === $trueParam[$j]) {
                    $resultParam[$arrKey[$i]] = $param[$i];
                    break;
                }
            }
        }
        return $param;
    }

    protected function parsePath($url)
    {
        $arrPath = explode('/', parse_url($url, PHP_URL_PATH));
        foreach ($arrPath as $value) {
            if($value !== '') {
                $arrRes[] = $value;
            }
        }
        return $arrRes;
    }

    public function parseUrl($url)
    {
        $arrPath = $this->parsePath($url);
        $count = count($arrPath);
        switch($count) {
            case 0:
                $this->callController($url);
                break;
            case 1:
                $this->callController($url, $arrPath[0]);
                break;
            case 2:
                $this->callController($url, $arrPath[0], $arrPath[1]);
                break;
            case 3:
                $this->callController($url, $arrPath[1], $arrPath[2], $arrPath[0]);
                break;
            default: echo 'No exist controller or action';
        }
    }

}