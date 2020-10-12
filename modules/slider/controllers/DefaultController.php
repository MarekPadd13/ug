<?php

namespace app\modules\slider\controllers;

use Yii;
use yii\web\Controller;
use app\modules\slider\models\Slider;
use app\modules\slider\models\SliderSearch;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use zxbodya\yii2\galleryManager\GalleryManagerAction;

/**
 * Default controller for the `slider` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */

        public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
{
    return [
       'galleryApi' => [
           'class' => GalleryManagerAction::className(),
           // mappings between type names and model classes (should be the same as in behaviour)
           'types' => [
               'slider' => Slider::className()
           ]
       ],
    ];
}


public function actionIndex()
    {
        $searchModel = new SliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->OrderBy(['id' => SORT_DESC]);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        $model = new Slider();
      
        if($model->load(Yii::$app->request->post())){
            $model->save(); 
     
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

        public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

        public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

         return $this->render('view', [
            'model' => $model,
        ]);
    }


        protected function findModel($id)
    {
        if (($model = Slider::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
