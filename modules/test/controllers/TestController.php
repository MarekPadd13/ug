<?php

namespace app\modules\test\controllers;

use app\models\Olimpic;
use app\modules\test\models\Test;
use app\modules\test\models\TestAttempt;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TestController extends Controller
{
    public function actionIndex($olimpicId)
    {
        $olimpicModel = Olimpic::findOne($olimpicId);
        if ($olimpicModel === null) {
            throw new NotFoundHttpException('Олимпиада не найдена.');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Test::find()->andWhere(['olimpic_id' => $olimpicModel->id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'olimpicModel' => $olimpicModel,
        ]);
    }

    public function actionCreate($olimpicId)
    {
        $model = new Test();
        $model->olimpic_id = $olimpicId;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/test/question', 'olimpicId' => $model->olimpic_id]);
        }

        return $this->renderAjax('_form', [
            'model' => $model,
            'isReadOnly' => false,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/test/question', 'olimpicId' => $model->olimpic_id]);
        }

        $isReadOnly = false;
        if (!Yii::$app->user->can('admin_faculty')) { //@todo эти настройки организатор может менять только до открытия тестирования, далее - только через администратора
            if (TestAttempt::find()->andWhere(['test_id' => $id])->exists()) {
                $isReadOnly = true;
            }
        }

        return $this->renderAjax('_form', [
            'model' => $model,
            'isReadOnly' => $isReadOnly,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
    }

    /**
     * @param int $id
     * @return Test
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Test::findOne($id)) === null) {
            throw new NotFoundHttpException('Страница не найдена.');
        }

        return $model;
    }
}
