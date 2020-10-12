<?php

namespace app\modules\sending\controllers;


use app\modules\sending\models\DictSendingTemplate;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;


class TemplateController extends Controller
{

    const CHECK = 1;
    const NO_CHECK = 0;

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => DictSendingTemplate::find()->andWhere(['user_id' => Yii::$app->user->id]),
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new DictSendingTemplate();
        $model->user_id = Yii::$app->user->id;
        $model->check_status = self::NO_CHECK;
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

        return null;

    }

    protected function findModel($id)
    {
        $model = DictSendingTemplate::find()->andWhere(['id' => $id])->one();

        return $model;
    }

}