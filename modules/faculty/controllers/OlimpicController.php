<?php

namespace app\modules\faculty\controllers;

use app\models\DictChairmans;
use app\models\DictCompetitiveGroup;
use app\models\DictSpeciality;
use app\models\DictSpecialization;
use Yii;
use app\models\Olimpic;
use app\models\OlimpicSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * OlimpicController implements the CRUD actions for Olimpic model.
 */
class OlimpicController extends Controller
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
     * Lists all Olimpic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OlimpicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Olimpic model.
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
     * Creates a new Olimpic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Olimpic();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($model->number_of_tours == 2) {
                $model->form_of_passage = 3;
                $model->save();
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Olimpic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->number_of_tours == 2) {
                $model->form_of_passage = 3;
                $model->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Olimpic model.
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
     * Finds the Olimpic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Olimpic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Olimpic::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    function actionGetCg($levelId)
    {
        if ($levelId == 1) {
            $cg = DictCompetitiveGroup::find()->andWhere(['edu_level' => DictCompetitiveGroup::EDUCATION_LEVEL_BACHELOR])->all();

        } elseif ($levelId == 2) {
            $cg = DictCompetitiveGroup::find()->andWhere(['edu_level' => DictCompetitiveGroup::EDUCATION_LEVEL_MAGISTER])->all();


        } elseif ($levelId == 3) {
            $cg = DictCompetitiveGroup::find()->andWhere(['edu_level' => DictCompetitiveGroup::EDUCATION_LEVEL_GRADUATE_SCHOOL])->all();

        } else {
            $cg = DictCompetitiveGroup::find()->andWhere(['edu_level' => DictCompetitiveGroup::EDUCATION_LEVEL_SPO])->all();

        }
        $result = [];
        foreach ($cg as $currentCg) {
            $result[] = [
                'id' => $currentCg->id,
                'text' => $currentCg->getFullName(),
            ];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['result' => $result];
    }
}
