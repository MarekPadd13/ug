<?php

namespace app\modules\faculty\controllers;

use Yii;
use app\models\DictClass;
use app\models\DictClassSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;


/**
 * DictClassController implements the CRUD actions for DictClass model.
 */
class DictClassController extends Controller
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
     * Lists all DictClass models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DictClassSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy(['type' => SORT_ASC]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new DictClass model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DictClass();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DictClass model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DictClass model.
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


    public function actionGetClassOnType($onlyHs)
    {
        if ($onlyHs == 2) {
            $model = DictClass::find()->andWhere(['type' => 3])->orderBy('id')->all();
        } elseif($onlyHs == 1) {
            $model = DictClass::find()->andWhere(['in', 'type', [1, 2]])->orderBy('id')->all();

        }else{
            $model = DictClass::find()->andWhere(['in', 'type', [4]])->orderBy('id')->all();
        }
        $class = [];
        $type = DictClass::typeOfClass();


        foreach ($model as $classes) {
            $class[] = [
                'id' => $classes->id,
                'name' => $classes->name . '-й ' . $type[$classes->type],
            ];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['class' => $class];

    }

    /**
     * Finds the DictClass model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DictClass the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DictClass::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
