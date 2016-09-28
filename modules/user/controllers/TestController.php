<?php

namespace modules\user\controllers;

use core\configs\Config;
use core\views\View;
use \modules\user\models\TestModel;

class TestController extends \core\controllers\Controller
{
    public function __construct()
    {
//        parent::__construct();
        $this->model = new TestModel();
        $this->view = new View(Config::get('moduleViewPath'));
    }


    public function actionTest()
    {
        $res = $this->model->select('id, name')->whereIdAndName(1, 'dima')->all();
        $this->view('test/test', ['response' => $res]);
    }

}