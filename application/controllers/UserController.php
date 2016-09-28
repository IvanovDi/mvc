<?php

namespace application\controllers;

use \core\configs\Controller;

class UserController
{
    public function actionIndex()
    {
        echo "\n index method \n";
    }

    public function actionShow($show, $ree)
    {
        echo "\n work is user method SHOW ------> {$show} ============{$ree}\n";
    }
}