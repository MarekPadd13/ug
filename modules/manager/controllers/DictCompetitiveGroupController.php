<?php

namespace app\modules\manager\controllers;

use Yii;
use app\models\DictCompetitiveGroup;
use app\models\DictCompetitiveGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\DisciplineCompetitiveGroup;

/**
 * DictCompetitiveGroupController implements the CRUD actions for DictCompetitiveGroup model.
 */
class DictCompetitiveGroupController extends Controller
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
     * Lists all DictCompetitiveGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DictCompetitiveGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DictCompetitiveGroup model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    /**
     * Creates a new DictCompetitiveGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DictCompetitiveGroup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DictCompetitiveGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAddDiscipline($id)
    {
        $model = new DisciplineCompetitiveGroup();
        $model->competitive_group_id = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $id]);
        }

        return $this->renderAjax('add-discipline', [
            'model' => $model,
        ]);
    }

    public function actionUpdateDiscipline($discipline_id, $competitive_group_id)
    {
        $model = $this->findDisciplineCg($discipline_id, $competitive_group_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id'=> $competitive_group_id]);
        }

        return $this->renderAjax('add-discipline', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DictCompetitiveGroup model.
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

    public function actionDeleteDsCg($discipline_id, $competitive_group_id)
    {
        $this->findDisciplineCg($discipline_id, $competitive_group_id)->delete();

        return $this->redirect(['update', 'id'=> $competitive_group_id]);
    }

    /**
     * Finds the DictCompetitiveGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DictCompetitiveGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DictCompetitiveGroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findDisciplineCg($discipline_id, $competitive_group_id)
    {
        $disciplineCg = DisciplineCompetitiveGroup::find()
            ->andWhere(['discipline_id'=>$discipline_id])
            ->andWhere(['competitive_group_id'=>$competitive_group_id])->one();
        if($disciplineCg !== null){
            return $disciplineCg;
        }
    }
}
