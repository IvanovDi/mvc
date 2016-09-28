<?php

namespace modules\user\controllers;

use core\configs\Config;
use core\models\Model;
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
        $res = $this->model->where(["id" => 2])->all();
        $this->view('test', ['response' => $res]);
    }

}