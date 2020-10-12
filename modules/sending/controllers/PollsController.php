<?php

namespace app\modules\sending\controllers;

use app\modules\sending\models\PollPollAnswer;
use Yii;
use app\modules\sending\models\Polls;
use app\modules\sending\models\PollsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PollsController extends Controller
{

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

    public function actionIndex()
    {
        $searchModel = new PollsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Polls();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (PollPollAnswer::hasPollAnswer($model->id)) {
                Yii::$app->session->setFlash('warning', 'Нужно добавить варианты ответов.');
                return $this->redirect(['index']);
            } else {
                return $this->redirect(['update', 'id' => $model->id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!PollPollAnswer::hasPollAnswer($id)) {
            Yii::$app->session->setFlash('warning', 'Нужно добавить варианты ответов.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAddItem($pollId)
    {
        $model = new PollPollAnswer();
        $model->poll_id = $pollId;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return null;
        }

        return $this->renderAjax('add-item', [
            'model' => $model,
        ]);


    }

    public function actionUpdateItem($poll_id, $poll_answer_id)
    {
        $model = $this->findItemModel($poll_id, $poll_answer_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return null;
        }
        return $this->renderAjax('add-item', [
            'model' => $model,
        ]);
    }

    public function actionDeleteItem($poll_id, $poll_answer_id)
    {
        $this->findItemModel($poll_id, $poll_answer_id)->delete();

        return null;
    }

    protected function findModel($id)
    {
        if (($model = Polls::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемой страницы не существует!');
    }

    protected function findItemModel($pollid, $itemId)
    {
        if (($model = PollPollAnswer::find()
                ->andWhere(['poll_id' => $pollid])
                ->andWhere(['poll_answer_id' => $itemId])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемой страницы не существует!');
    }

}
