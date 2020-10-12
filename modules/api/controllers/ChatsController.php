<?php

namespace app\modules\api\controllers;

use app\modules\api\providers\MapDataProvider;
use yii\rest\Controller;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\auth\HttpBasicAuth;
use app\models\User;
use yii\helpers\ArrayHelper;
use app\models\Profiles;
use app\models\Chats;
use Yii;

class ChatsController extends Controller
{
    
   public $service;
   public function behaviors()
{
  $behaviors = parent::behaviors();
  $behaviors['authenticator']['class'] = HttpBasicAuth::className();
  $behaviors['authenticator']['auth'] = function ($username, $password) {
   $u =  User::findOne([
        'username' => $username,
    ]);

        return (Yii::$app->getSecurity()->validatePassword($password, $u->password_hash)) ? $u : null;

};
     $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [  'actions' => ['index', 'uiid', 'profile', 'update-profile', "chat-list", 'chats', 'add-message', 'chat-looked'],
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
            'chat-list' => ['GET'],
            'chat-looked' => ['POST'],
            'chats' => ['GET'],
            'update-profile' => ['POST'],
            'add-message' => ['POST'],
            'profile' => ['GET'],
            'index' => ['GET'],
        ];
    }

    public function actionIndex()
    {
        return ['status' => "ok"];
    }

  public function actionChatList($username)
    { 
      $dataProvider = new ActiveDataProvider(['query' => User::find()->where(["id" =>$this->userList($username) ])]);
       $d = new MapDataProvider($dataProvider, [$this, 'serializeListItem']);
       return [ "chatList" => $d->getModels()];
    }

    public function actionChats($username, $user_recive)
    { 
      $user = $this->user($username);
      $dataProvider = new ActiveDataProvider(['query' => Chats::find()->where(["receiver" => [$user->id, $user_recive], "sender"=> [$user->id, $user_recive],'looked'=> [0,1]])->orderBy(['created_at' => SORT_DESC])]);
       $d = new MapDataProvider($dataProvider, [$this, 'serializeChatsItem']);
       return [ "listChat" => $d->getModels()];
    }



    private function userList($username)
    { 
      $user = $this->user($username);
      $chats = Chats::find()->where(["receiver" => $user->id])->orWhere(["sender"=> $user->id])->groupBy(["receiver","sender"])->all();

      $result = [];
      foreach ($chats as  $chat) {
       $result  []= ["users" =>  $chat->sender, "userr" => $chat->receiver];
      }
      $r = ArrayHelper::getColumn($result, 'userr');
      $s = ArrayHelper::getColumn($result, 'users');
      $d = array_merge($r, $s);
      $d = array_unique($d);
      unset($d[array_search($user->id, $d)]);
      return array_values($d);
    }

    private function user ($username) {
      $user = User::findOne(['username' => $username]);
      return $user;
    }

    private function profile($user_id) {
      $profile = Profiles::findOne(['user_id' => $user_id]);
      return $profile;
    }

    


    public function actionProfile($username)
    {
      $user = $this->user($username);
      $profile = $this->profile($user->id);
      return [
            'id_user' => $user->id,
            'last_name' => $profile->last_name ? $profile->last_name  : "" ,
            'first_name' => $profile->first_name ? $profile->first_name  : "" ,
            'phone' =>   $profile->phone ? $profile->phone  : "" ,
            'patronymic' =>   $profile->patronymic ? $profile->patronymic  : "" ,
            'photo' => "",
        ]; 
    }

    public function actionUpdateProfile($username)
    {
      $user = $this->user($username);
      $profile = $this->profile($user->id);
      if(!$profile) {
        $form = new Profiles();
      } else {
        $form = Profiles::findOne(['user_id' => $user->id]);
      }
      $form->load(Yii::$app->request->getBodyParams(), '');
          
      try {
                $form->user_id = $user->id;
                $form->save(false);
                $response = Yii::$app->getResponse();
                $response->setStatusCode(204);
                
            } catch (\DomainException $e) {
                throw new BadRequestHttpException($e->getMessage(), null, $e);
            }

          return $form;
    }


    public function actionChatLooked($id_chat, $looked)
    { 
      $chat = Chats::findOne($id_chat);
      $chat->looked = $looked;
      $chat->save();
      return [
            'id_chat' => $chat->id,
            'receiver' => $chat->receiver,
            'sender' => $chat->sender,
            'message'=> $chat->message,
            'created' => $chat->created_at,
            'looked' => $chat->looked,
      ];
    }


    public function actionAddMessage()
    {
      
      $form = new Chats();
      $form->load(Yii::$app->request->getBodyParams(), '');
      try {
                $form->save(false);
          return [
            'id_chat' => $form->id,
            'receiver' => $form->receiver,
            'sender' => $form->sender,
            'message'=> $form->message,
            'created' => $form->created_at,
            'looked' => $form->looked,
        ];
                
            } catch (\DomainException $e) {
                throw new BadRequestHttpException($e->getMessage(), null, $e);
            }

          return $form;
    }


    public function serializeListItem(User $user)
    {
       $profile = $this->profile($user->id);
        return [
            'id_user' => $user->id,
            'last_name' => $profile->last_name ? $profile->last_name  : "" ,
            'first_name' => $profile->first_name ? $profile->first_name  : "" ,
            'phone' =>   $profile->phone ? $profile->phone  : "" ,
            'patronymic' =>   $profile->patronymic ? $profile->patronymic  : "" ,
        
            'photo' => null,
        ];
    }

    public function serializeChatsItem(Chats $chat)
    {
        return [
            'id_chat' => $chat->id,
            'receiver' => $chat->receiver,
            'sender' => $chat->sender,
            'message'=> $chat->message,
            'created' => $chat->created_at,
            'looked' => $chat->looked,
        ];
    }

    // public function serializeListItemChats(User $user)
    // {
    //     return [
    //         'fio' => $user->userProfile->fio 
    //         ? $user->userProfile->fio : "" ,
    //         'address' => $user->userProfile->address ? $user->userProfile->address : "" ,
    //         'fac' => $user->userProfile->fac ? $user->userProfile->fac : "",
    //         'photo' =>$user->userProfile->photo ? $user->userProfile->getThumbFileUrl('photo', 'thumb') : null,
    //     ];
    // }

}