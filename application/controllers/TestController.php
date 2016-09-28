<?php
namespace application\controllers;

use application\models\TestModel;
use core\controllers\Controller;

class TestController extends Controller
{
    public function actionIndex($from, $to)
    {
        $data = (new TestModel())
            ->where('id', '!=', 100000)
            ->whereBetween('id', $from, $to)
            ->orderBy([
                'id' => 'asc',
                'age',
                'name' => 'desc'
            ])
            ->all();
        return $this->view('test/index', [
            'response' => $data
        ]);
    }
}