<?php

namespace application\controllers;

use core\configs\Config;
use core\views\View;
use  application\models\DimaModel;

class DimaController extends \core\controllers\Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new DimaModel();
        $this->view = new View(Config::get('viewPath'));
    }

    public function actionIndex()
    {
        $res = $this->model->whereId(1)->all();

//        return $this->view('index', [
//            'data' => $res,
//        ]);
        $this->view('dima/index', ['response' => $res]);

    }
}