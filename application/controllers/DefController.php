<?php

namespace application\controllers;

use core\controllers\Controller;

class DefController extends Controller
{


    public function view($path, $data)
    {
        require $path;
    }

    public function actionIndex()
    {
        echo "\nCALL DEFAULT\n";
    }
}
