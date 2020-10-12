<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\OlimpiadsTypeTemplates;
use app\models\OlimpiadsTypeTemplatesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OlimpiadsTypeTemplatesController implements the CRUD actions for OlimpiadsTypeTemplates model.
 */
class OlimpiadsTypeTemplatesController extends Controller
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
     * Lists all OlimpiadsTypeTemplates models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OlimpiadsTypeTemplatesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OlimpiadsTypeTemplates model.
     * @param integer $number_of_tours
     * @param integer $form_of_passage
     * @param integer $edu_level_olimp
     * @param integer $template_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id),
        ]);
    }

    /**
     * Creates a new OlimpiadsTypeTemplates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OlimpiadsTypeTemplates();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'number_of_tours' => $model->number_of_tours, 'form_of_passage' => $model->form_of_passage, 'edu_level_olimp' => $model->edu_level_olimp, 'template_id' => $model->template_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OlimpiadsTypeTemplates model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $number_of_tours
     * @param integer $form_of_passage
     * @param integer $edu_level_olimp
     * @param integer $template_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id)
    {
        $model = $this->findModel($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'number_of_tours' => $model->number_of_tours, 'form_of_passage' => $model->form_of_passage, 'edu_level_olimp' => $model->edu_level_olimp, 'template_id' => $model->template_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing OlimpiadsTypeTemplates model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $number_of_tours
     * @param integer $form_of_passage
     * @param integer $edu_level_olimp
     * @param integer $template_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id)
    {
        $this->findModel($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the OlimpiadsTypeTemplates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $number_of_tours
     * @param integer $form_of_passage
     * @param integer $edu_level_olimp
     * @param integer $template_id
     * @return OlimpiadsTypeTemplates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id)
    {
        if (($model = OlimpiadsTypeTemplates::findOne(['number_of_tours' => $number_of_tours, 'form_of_passage' => $form_of_passage, 'edu_level_olimp' => $edu_level_olimp, 'template_id' => $template_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
