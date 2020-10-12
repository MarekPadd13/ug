<?php

namespace api\controllers;

use demo\models\Posts;
use api\providers\MapDataProvider;
use yii\rest\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;
use Yii;

class PostsController extends Controller
{
    // private $products;
    // private $categories;
    // private $brands;
    // private $tags;

    // public function __construct(
    //     $id,
    //     $module,
    //     ProductReadRepository $products,
    //     CategoryReadRepository $categories,
    //     BrandReadRepository $brands,
    //     TagReadRepository $tags,
    //     $config = []
    // )
    // {
    //     parent::__construct($id, $module, $config);
    //     $this->products = $products;
    //     $this->categories = $categories;
    //     $this->brands = $brands;
    //     $this->tags = $tags;
    // }


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
                [  'actions' => ['index',"create"],
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


   public function actionCreate()
    {
         
         $form = new Posts();
         $form->load(Yii::$app->request->getBodyParams(), '');
        // $form->name ="sd";
       //   $form->brand_id = 2;

          if ($form->validate() && $form->title) {
            try {  $form->save(false);
                $response = Yii::$app->getResponse();
                $response->setStatusCode(204);
                return [];
            } catch (\DomainException $e) {
                throw new BadRequestHttpException($e->getMessage(), null, $e);
            }
        }

          return $form;

      
   
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(['query' => Posts::find()]);
         return  new MapDataProvider($dataProvider, [$this, 'serializeListItem']);
    }

     public function serializeListItem(Posts $posts)
    {
        return [
            'id' => $posts->id,
            'title' => $posts->title,
            'text' => $posts->text,
            'brands' => [
               'brand_id' => $posts->brand_id,
                'name' =>  $posts->brands->name
            ]    

        ];
    }
}