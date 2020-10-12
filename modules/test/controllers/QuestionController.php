<?php

namespace app\modules\test\controllers;

use app\models\Olimpic;
use app\modules\test\models\TestQuestion;
use app\modules\test\models\TestQuestionGroup;
use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class QuestionController extends Controller
{
    public function actionIndex($olimpicId)
    {
        $olimpicModel = Olimpic::findOne($olimpicId);
        if ($olimpicModel === null) {
            throw new NotFoundHttpException('Олимпиада не найдена.');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => TestQuestion::find()
                ->joinWith(['group'])
                ->andWhere([TestQuestionGroup::tableName() . '.olimpic_id' => $olimpicModel])
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'olimpicModel' => $olimpicModel,
        ]);
    }

    public function actionCreate($typeId, $olimpicId)
    {
        $model = new TestQuestion();
        $model->type_id = $typeId;
        if ($model->load(Yii::$app->request->post())) {
            $model->group_id = $this->checkNewGroup($model->group_id, $olimpicId);
            if ($model->save()) {
                return null;
            }
            Yii::warning(print_r($model->errors, true));
        }

        return $this->renderAjax('_form', [
            'model' => $model,
            'olimpicId' => $olimpicId,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->group_id = $this->checkNewGroup($model->group_id, $model->group->olimpic_id);
            if ($model->save()) {
                return null;
            }
        }

        return $this->renderAjax('_form', [
            'model' => $model,
            'olimpicId' => $model->group->olimpic_id,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
    }

    /**
     * @param int $id
     * @return TestQuestion
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = TestQuestion::findOne($id)) === null) {
            throw new NotFoundHttpException('Страница не найдена.');
        }

        return $model;
    }

    /**
     * @param int $groupId
     * @param int $olimpicId
     * @return int
     * @throws Exception
     */
    protected function checkNewGroup($groupId, $olimpicId)
    {
        if (!TestQuestionGroup::find()->andWhere(['id' => $groupId])->exists()) {
            $newGroup = new TestQuestionGroup();
            $newGroup->olimpic_id = $olimpicId;
            $newGroup->name = $groupId;
            if (!$newGroup->save()) {
                throw new Exception('');
            }

            return $newGroup->id;
        }

        return $groupId;
    }
}
