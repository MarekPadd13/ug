<?php

namespace app\modules\news\controllers;

use Yii;
use yii\web\Controller;
use app\models\News;
use app\models\NewsSearch;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `news` module
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


public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->OrderBy(['id' => SORT_DESC]);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        $model = new News();
      
        if($model->load(Yii::$app->request->post())){
            $model->date_of_publication = Date('Y-m-d H:i:s');
            $model->user_id = Yii::$app->user->id;
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
            $model->update_user_id = Yii::$app->user->id;
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

        protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
