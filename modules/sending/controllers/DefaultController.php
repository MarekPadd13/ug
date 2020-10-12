<?php

namespace app\modules\sending\controllers;

use yii\web\Controller;

/**
 * Default controller for the `sending` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAllSending()
    {
        return $this->render('index');
    }
}
