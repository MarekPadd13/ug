<?php

namespace app\modules\manager\controllers;

use Yii;
use app\models\DisciplineCompetitiveGroup;
use app\models\DisciplineCompetitiveGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DisciplineCompetitiveGroupController implements the CRUD actions for DisciplineCompetitiveGroup model.
 */
class DisciplineCompetitiveGroupController extends Controller
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
     * Lists all DisciplineCompetitiveGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DisciplineCompetitiveGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->OrderBy(['discipline_id' => SORT_DESC]);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Creates a new DisciplineCompetitiveGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DisciplineCompetitiveGroup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DisciplineCompetitiveGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $discipline_id
     * @param integer $competitive_group_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($discipline_id, $competitive_group_id)
    {
        $model = $this->findModel($discipline_id, $competitive_group_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DisciplineCompetitiveGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $discipline_id
     * @param integer $competitive_group_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($discipline_id, $competitive_group_id)
    {
        $this->findModel($discipline_id, $competitive_group_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DisciplineCompetitiveGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $discipline_id
     * @param integer $competitive_group_id
     * @return DisciplineCompetitiveGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($discipline_id, $competitive_group_id)
    {
        if (($model = DisciplineCompetitiveGroup::findOne(['discipline_id' => $discipline_id, 'competitive_group_id' => $competitive_group_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
