<?php

namespace app\modules\api\controllers;


use yii\rest\Controller;
use Yii;
use yii\web\Response;


use yii\filters\ContentNegotiator;


/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
   public function actionIndex()
    {
        return [
            'version' => '1.0.0',
        ];
    }

   public function behaviors()
  {
    return [
      'contentNegotiator' => [
              'class' => ContentNegotiator::className(),
              'formats' => [
                  'application/json' => Response::FORMAT_JSON,
              ],
          ]
    ];
  }

}
