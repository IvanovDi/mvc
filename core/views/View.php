<?php

namespace core\views;

class View
{
    protected $viewPath;

    public function __construct($viewPath)
    {
        $this->viewPath = $viewPath;
    }

    function generate($path, $data = [])
    {
        extract($data);
        include $this->viewPath . $path.'.php';
    }
}