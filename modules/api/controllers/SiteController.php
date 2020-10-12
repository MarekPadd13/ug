<?php
namespace \api\controllers;

use yii\rest\Controller;
use Yii;
use yii\web\Response;
use frontend\models\SignupForm;
use demo\models\Chats;

use yii\filters\ContentNegotiator;

class SiteController extends Controller
{
   
    public function actionIndex()
    {
        return [
            'version' => '1.0.0',
        ];
    }

    public function verbs()
    {
        return [
           // 'activate' => ['POST'],
            'create' => ["POST"],
            'chat' => ["GET"],
            'search' => ['GET'],
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

    public function actionCreate()
    {
       $form = new SignupForm();
         $form->load(Yii::$app->request->getBodyParams(), '');
            try {
            	  $user = $form->signupApi();
                $chat = new Chats(['message'=> "Добро пожаловать", 'receiver'=> $user->id, 'sender' => 18]);
                $chat->save();
                $response = Yii::$app->getResponse();
                $response->setStatusCode(204);
                
            } catch (\DomainException $e) {
                throw new BadRequestHttpException($e->getMessage(), null, $e);
            }

          return $form;


    }

    public function actionChat()
    {
      
      $form = new Chats(); 
     
      $form->load(Yii::$app->request->getBodyParams(), '');
      try {
               $form->receiver = 1; 
                // $form->message ="554";
                $form->sender = 18;
                $form->save();
                $response = Yii::$app->getResponse();
                $response->setStatusCode(204);
            } catch (\DomainException $e) {
                throw new BadRequestHttpException($e->getMessage(), null, $e);
            }

          return $form;
    }



}
