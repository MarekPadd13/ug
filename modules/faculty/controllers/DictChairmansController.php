<?php

namespace app\modules\faculty\controllers;

use Yii;
use app\models\DictChairmans;
use app\models\DictChairmansSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * DictChairmansController implements the CRUD actions for DictChairmans model.
 */
class DictChairmansController extends Controller
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
     * Lists all DictChairmans models.
     * @return mixed
     */
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query'=> DictChairmans::find(),
        ]);

        return $this->render('index', [
            'dataProvider'=> $dataProvider,
        ]);
    }

    /**
     * Creates a new DictChairmans model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DictChairmans();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['index']);
            return null;
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);

    }

    public function actionCreateFromOlimpic()
    {
        $model = new DictChairmans();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           return $this->redirect(['/faculty/olimpic/create']);
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing DictChairmans model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return null;
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DictChairmans model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DictChairmans model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DictChairmans the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DictChairmans::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
