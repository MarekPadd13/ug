<?php

namespace app\modules\faculty\controllers;

use app\models\Profiles;
use app\models\UserDod;
use app\models\ProfilesSearch;
use function GuzzleHttp\Psr7\str;
use yii\debug\models\search\Profile;
use yii\web\Controller;
use Yii;
use app\models\Dod;
use app\models\DictFaculty;
use app\models\UserFaculty;

/**
 * Default controller for the `faculty` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */


//    public function actionAdmin()
//    {
//        $searchModel = new UserFacultySearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('admin', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }


//
//    public function actionIndex()
//    {
//        $searchModel = new DictCompetitiveGroupSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }
    public function actionIndex()
    {
        $userFaculty = UserFaculty::find()->andWhere(['user_id' => Yii::$app->user->id])->one(); //определяем факультет пользователя

        if ($userFaculty) {
            $facultyDod = Dod::find()->select('id')->andWhere(['faculty_id' => $userFaculty->faculty_id])->andWhere(['type' => 0])->column(); // определяем все дни открытых дверей для данного факультета
            if ($facultyDod) {
                $abiturDod = UserDod::find()->select('user_id')->andWhere(['in', 'dod_id', $facultyDod])->distinct()->column(); // определем все зарегистрированных на эти дни открытых дверей
            }
        }else {
            Yii::$app->session->setFlash('warning', 'На данный момент у Вашего института/факультета нет ни одного абитуриента');
            return $this->redirect('/site/index');
        }

        $facultyId = DictFaculty::find()->select('full_name')->indexBy('id')->column(); //массив с факультетами для отображения названия факультета в заголовке


        $title = 'Абитуриенты МПГУ (всех институтов и факультетов)';
        if ($userFaculty) {
            $title = 'Абитуриенты, планирующие поступать в ' . $facultyId[$userFaculty->faculty_id]; //меняющийся заголовок страницы в зависимости от типа пользователя
        }


        $searchModel = new ProfilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($userFaculty !== null) {
            $dataProvider->query->andWhere(['in', 'user_id', $abiturDod])->distinct()->all();

        } else {
            $dataProvider->query->andWhere(['not in', 'user_id', UserFaculty::find()->select('user_id')->column()])->distinct()->all();
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => $title,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($this->ownAbiturient($model->user_id)) {

            return $this->render('view', [
                'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Данный абитуриент не является абитуриентом вашего Института/факультета');
            return $this->redirect('index');
        }
    }

    protected function findModel($id)
    {
        if (($model = Profiles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Нет такого профиля.');
    }

    protected function ownAbiturient($userId)
    {
        $userFaculty = UserFaculty::find()->andWhere(['user_id' => Yii::$app->user->id])->one(); //определяем факультет пользователя
        $facultyDod = Dod::find()->select('id')->andWhere(['faculty_id' => $userFaculty->faculty_id])->andWhere(['type' => 0])->column(); // определяем все дни открытых дверей для данного факультета
        $abiturDod = UserDod::find()->select('user_id')->andWhere(['in', 'dod_id', $facultyDod])->column(); // определем все зарегистрированных на эти дни открытых дверей

        if (in_array($userId, $abiturDod)) {
            return true;
        } else {
            return false;
        }
    }
}
