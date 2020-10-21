<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\EndHomeBuild;
use app\models\EndHomeBuildSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EndHomeBuildController implements the CRUD actions for EndHomeBuild model.
 */
class EndHomeBuildController extends Controller
{
    /**
     * {@inheritdoc}
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

    /**
     * Lists all EndHomeBuild models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EndHomeBuildSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new EndHomeBuild model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $homeId = Yii::$app->request->get('home_id');
        $model = new EndHomeBuild(['home_id'=> $homeId ?? null]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($homeId  ?['/admin/dict-houses/view', 'id' => $model->home_id] : ['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EndHomeBuild model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $homeId = Yii::$app->request->get('home_id');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect($homeId  ?['/admin/dict-houses/view', 'id' => $model->home_id] : ['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EndHomeBuild model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EndHomeBuild model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EndHomeBuild the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EndHomeBuild::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
