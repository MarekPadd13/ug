<?php

namespace app\modules\test\controllers;

use app\modules\test\models\Test;
use app\modules\test\models\TestAttempt;
use app\modules\test\models\TestGroup;
use app\modules\test\models\TestQuestion;
use app\modules\test\models\TestResult;
use Yii;
use yii\base\Exception;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class AttemptController extends Controller
{
    /** @var Test */
    protected $testModel;
    /** @var TestAttempt */
    protected $attemptModel;

    public function actionStart($testId)
    {
        $this->findModel($testId);
        if ($this->attemptModel === null) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $this->attemptModel = new TestAttempt();
                $this->attemptModel->user_id = Yii::$app->user->id;
                $this->attemptModel->test_id = $this->testModel->id;
                $this->attemptModel->start = \date('Y-m-d H:i:s');
                if (!$this->attemptModel->save()) {
                    throw new Exception(\print_r($this->attemptModel->errors, true));
                }

                foreach (TestGroup::find()->andWhere(['test_id' => $this->testModel->id])->select('question_group_id')
                             ->column() as $groupId) {
                    /** @var TestQuestion $question */
                    $question = TestQuestion::find()
                        ->andWhere(['group_id' => $groupId])
                        ->limit(1)
                        ->orderBy(new Expression('RAND()'))
                        ->one();
                    if ($question === null) {
                        continue;
                    }

                    $result = new TestResult();
                    $result->attempt_id = $this->attemptModel->id;
                    $result->question_id = $question->id;
                    if (!$result->save()) {
                        throw new Exception(\print_r($result->errors, true));
                    }
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
            $transaction->commit();

            return $this->render('start', ['attemptModel' => $this->attemptModel]);
        }

        if ($this->isEnd()) {
            return $this->redirect(['end', 'testId' => $this->attemptModel->test_id]);
        }

        return $this->redirect(['process', 'testId' => $this->attemptModel->test_id]);
    }

    public function actionProcess($testId, $question = 1)
    {
        $this->findModel($testId);
        if ($this->attemptModel === null) {
            return $this->redirect(['start', 'testId' => $testId]);
        }
        if ($this->isEnd()) {
            return $this->redirect(['end', 'testId' => $this->attemptModel->test_id]);
        }

        /** @var TestResult $resultModel */
        $resultModel = TestResult::find()
            ->with(['question'])
            ->andWhere(['attempt_id' => $this->attemptModel])
            ->orderBy('question_id')
            ->limit(1)
            ->offset($question - 1)
            ->one();
        if ($resultModel === null) {
            throw new NotFoundHttpException('Вопрос не найден.');
        }

        if (Yii::$app->request->isPost) {
            $resultModel->resultArray = Yii::$app->request->post('TestResult')['resultArray'] ?? [];
            $resultModel->resultFile = UploadedFile::getInstance($resultModel, 'resultFile');

            $resultModel->save();
        }

        return $this->render('process', ['resultModel' => $resultModel, 'question' => $question]);
    }

    public function actionEnd($testId)
    {
        $this->findModel($testId);
        if ($this->attemptModel === null) {
            throw new NotFoundHttpException('Попытка не найдена.');
        }

        if (!$this->attemptModel->end) {
            $this->attemptModel->end = \date('Y-m-d H:i:s');
            if (!$this->attemptModel->save()) {
                throw new Exception(\print_r($this->attemptModel->errors, true));
            }
        }

        return $this->render('end', ['attemptModel' => $this->attemptModel]);
    }

    protected function findModel($testId)
    {
        $this->testModel = Test::findOne($testId);
        if ($this->testModel === null) { // @todo и другие проверки на права сдачи теста
            throw new NotFoundHttpException('Тест не найден.');
        }
        $this->attemptModel = TestAttempt::find()
            ->andWhere(['user_id' => Yii::$app->user->id, 'test_id' => $this->testModel->id])
            ->one();
    }

    /**
     * Окончен или должен быть окончен тест.
     * @return bool
     */
    protected function isEnd()
    {
        return $this->attemptModel->end ||
            (\time() - \strtotime($this->attemptModel->start)) > ($this->testModel->olimpic->time_of_tour * 60);
    }
}
