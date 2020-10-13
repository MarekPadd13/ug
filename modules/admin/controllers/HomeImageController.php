<?php

namespace app\modules\admin\controllers;

use app\models\DictAngle;
use app\modules\admin\form\HomeImageForm;
use app\modules\admin\services\HomeImageService;
use Yii;
use app\models\HomeImage;
use app\models\HomeImageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HomeImageController implements the CRUD actions for HomeImage model.
 */
class HomeImageController extends Controller
{
    /**
     * {@inheritdoc}
     */

    private  $service;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'status' => ['POST'],
                ],
            ],
        ];
    }

    public function __construct($id, $module, HomeImageService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * Lists all HomeImage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HomeImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HomeImage model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HomeImage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new HomeImageForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $model = $this->service->create($form);
                return $this->redirect(['view', 'id' => $model->id]);
            }catch (\RuntimeException $e) {
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing HomeImage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new HomeImageForm($model);
        $form->scenario = HomeImageForm::SCENARIO_UPDATE;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($model, $form);
                return $this->redirect(['view', 'id' => $model->id]);
            }catch (\RuntimeException $e) {
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'homeImage' =>$model
        ]);
    }

    /**
     * Deletes an existing HomeImage model.
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
     * Update Status an existing HomeImage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $status
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */

    public function actionStatus($id, $status)
    {
        $model = $this->findModel($id);
        try {
            $this->service->status($model, $status);
        }catch (\RuntimeException $exception) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }
          return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * Finds the HomeImage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HomeImage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HomeImage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
