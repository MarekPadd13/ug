<?php

namespace app\modules\test\controllers;

use app\modules\test\models\TestQuestionGroup;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class QuestionGroupController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TestQuestionGroup::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new TestQuestionGroup();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return null;
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

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

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
    }

    protected function findModel($id)
    {
        if (($model = TestQuestionGroup::findOne($id)) === null) {
            throw new NotFoundHttpException('Страница не найдена.');
        }

        return $model;
    }
}
