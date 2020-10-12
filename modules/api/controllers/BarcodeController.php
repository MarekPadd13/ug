<?php

namespace app\modules\api\controllers;

use demo\models\Barcodes;
use demo\forms\BarcodeAPIForm;
use api\providers\MapDataProvider;
use yii\rest\Controller;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\auth\HttpBasicAuth;
use common\models\User;
use Yii;

class ChatsController extends Controller
{
    
   public $service;


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
            
            'status' => ["POST"],
            'search' => ['GET'],
        ];
    }

    public function actionIndex()
    {
        return ['status' => "ok"];
    }

     public function actionUiid($user)
    {
        return ['status' => "ok"];
    }

    public function actionSearch($code)
    {
       $dataProvider = new ActiveDataProvider(['query' => Barcodes::find()->where(["code" =>$code ])]);
       
       return new MapDataProvider($dataProvider, [$this, 'serializeListItem']);
       
    }

   public function actionStatus($code)
    {   
    	$barcode = $this->findModel($code);
        $form = new BarcodeAPIForm($barcode);
        $form->load(Yii::$app->request->getBodyParams(), '');

          if ($form->validate()) {
            try {  $this->service->apiEdit($barcode->code, $form);
                $response = Yii::$app->getResponse();
                $response->setStatusCode(204);
                return [];
            } catch (\DomainException $e) {
                throw new BadRequestHttpException($e->getMessage(), null, $e);
            }
        }

          return $form;

    }

    protected function findModel($code)
    {     
        if (($model = Barcodes::findOne(["code"=>$code])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');


}

   

     public function serializeListItem(Barcodes $barcode)
    {
        return [
            'code' => $barcode->code,
            'status' => $barcode->status,
            'user_fio' => $barcode->abitur->fio,
            'user_passport' => $barcode->abitur->passport,
            'user_address' => $barcode->abitur->address,
            'url_s' =>$barcode->abitur->photo ? $barcode->abitur->getThumbFileUrl('photo', 'thumb') : null,

        ];
    }
}