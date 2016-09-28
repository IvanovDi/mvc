<?php

namespace core\controllers;

use core\configs\Config;
use core\views\View;

class Controller
{
    public $model;
    public $view;
//сделать динамическое получение имени контроллера
    function __construct()
    {
        $viewPath = Config::get("viewPath");
        $this->view = new View($viewPath);
    }

    protected function view($view, $param = [])
    {
        $this->view->generate($view, $param);
    }
}