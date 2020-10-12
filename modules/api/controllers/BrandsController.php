<?php

namespace api\controllers;

use demo\models\Brands;
use api\providers\MapDataProvider;
use yii\rest\Controller;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\auth\HttpBasicAuth;
use Yii;

class BrandsController extends Controller
{
 public function behaviors()
{
  $behaviors = parent::behaviors();
  $behaviors['authenticator']['class'] = HttpBasicAuth::className();
  $behaviors['authenticator']['auth'] = function ($username, $password) {
   $u =  \common\models\User::findOne([
        'username' => $username,
    ]);

        return (Yii::$app->getSecurity()->validatePassword($password, $u->password_hash)) ? $u : null;

};
   $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [  'actions' => ['index'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                
            ],
        ];

        $behaviors [] = [ "class" => \yii\filters\ContentNegotiator::className(),
        'formats' => [
            'application/json' => \yii\web\Response::FORMAT_JSON,
        ],
    ];

        return $behaviors;


}

 public function verbs()
    {
        return [
            'create' => ['POST'],
        ];
    }


    public function actionIndex()
    {
        return ['status' => "ok"];
    }

    public function actionBrands()
    {
        $dataProvider = new ActiveDataProvider(['query' => Brands::find()]);
         return new MapDataProvider($dataProvider, [$this, 'serializeListItem']);
    }

    public function actionCreate()
    {
         
         $form = new Brands();
         $form->load(Yii::$app->request->getBodyParams(), '');
        // $form->name ="sd";
       

          if ($form->validate()) {
            try {  $form->save();
                $response = Yii::$app->getResponse();
                $response->setStatusCode(204);
                return [];
            } catch (\DomainException $e) {
                throw new BadRequestHttpException($e->getMessage(), null, $e);
            }
        }

          return $form;

   
    }


     public function serializeListItem(Brands $brand)
    {
        return [
            'id' => $brand->id,
            'name' => $brand->name,

        ];
    }
}