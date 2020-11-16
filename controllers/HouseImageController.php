<?php

namespace app\controllers;

use app\models\DictAngle;
use app\models\DictHouses;
use app\models\HomeImage;
use app\modules\admin\form\HomeImageForm;
use app\modules\admin\services\HomeImageService;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class HouseImageController extends Controller
{
    public $service;


    public function __construct($id, $module, HomeImageService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * Lists all Stream models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = DictHouses::find()->innerJoin(HomeImage::tableName(), 'home_id=dict_houses.id')
            ->where(['moderation'=> DictHouses::ADD_MODERATION, 'status'=> HomeImage::STATUS_PUBLISHED])
            ->distinct()->orderBy(['dict_houses.id'=>SORT_DESC]);
        $data = new ActiveDataProvider(['query' => $query, 'sort' => false]);
        return $this->render('index', [
            'data' => $data
        ]);
    }
    /**
     * @param integer $id
     * @param integer $angle_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */


    public function actionView($id, $angle_id =null)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Stream model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddPhoto()
    {
        $form = new HomeImageForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                Yii::$app->session->setFlash('success','Успешно загружено. Ожидайте модерацию' );
                return $this->redirect(['index']);
            }catch (\RuntimeException $e) {
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);

    }

    /**
     * @param integer $home_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAddPhotoHome($home_id)
    {
        $model = $this->findModel($home_id);
        $form = new HomeImageForm(null,['home_id'=> $model->id]);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                Yii::$app->session->setFlash('success','Успешно загружено. Ожидайте модерацию');
                return $this->redirect(['view', 'id'=> $model->id]);
            }catch (\RuntimeException $e) {
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }

        return $this->render('create-photo-home', [
            'model' => $form,
            'home' => $model
        ]);
    }


    /**
     * @param integer $home_id
     * @param integer $angle_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAddPhotoHomeAndAngle($home_id, $angle_id)
    {
        $modelAngle = $this->findModelAngle($angle_id);
        $modelHome = $this->findModel($home_id);
        $form = new HomeImageForm(null,['home_id'=> $modelHome->id, 'angle_id'=> $modelAngle->id]);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                Yii::$app->session->setFlash('success','Успешно загружено. Ожидайте модерацию');
                return $this->redirect(['view', 'id'=> $modelHome->id]);
            }catch (\RuntimeException $e) {
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }
        return $this->render('create-photo-home-and-angle', [
            'model' => $form,
            'home' => $modelHome,
            'angleName' => $modelAngle->name,
        ]);
    }

    /**
     * Finds the Stream model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DictHouses
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DictHouses::findOne(['id'=> $id, 'moderation'=> DictHouses::ADD_MODERATION ])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Stream model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DictAngle
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelAngle($id)
    {
        if (($model = DictAngle::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
