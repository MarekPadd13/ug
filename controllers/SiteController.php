<?php

namespace app\controllers;

use app\components\DateTimeToChpu;
use app\models\CarpoolingMetro;
use app\models\CarpoolingPassengers;
use app\models\CarpoolingTrip;
use app\models\CarpoolingTripSearch;
use app\models\DictHouses;
use app\models\DictMetro;
use app\models\DocumentsSearch;
use app\models\Polls;
use app\models\RealVoteResult;
use app\models\Stream;
use app\models\UserHouseApart;
use app\modules\sending\models\DictSendingUserCategory;
use app\modules\sending\models\SendingUserCategory;
use Faker\Provider\zh_TW\DateTime;
use phpbb\exception\http_exception;
use supplyhog\ClipboardJs\ClipboardJsWidget;
use Yii;
use yii\db\Exception;
use yii\helpers\Html;
use yii\web\Controller;
use yii\bootstrap\ActiveForm;
use yii\web\HttpException;
use yii\web\Response;
use app\models\LoginForm as Login;
use app\models\Signup;
use app\models\Profiles;
use app\models\ProfilesSearch;
use app\models\User;
use app\models\Questions;
use app\models\DictBanks;
use app\models\RefProblems;
use mdm\admin\models\form\PasswordResetRequest;
use mdm\admin\models\form\ResetPassword;
use mdm\admin\models\form\ChangePassword;
use app\models\News;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\RefAnswer;
use app\models\RefMembers;
use app\models\RefActivity;
use app\models\RefDoljnost;
use app\models\RefMembersSearch;
use app\models\RefProblemsUser;
use app\models\RefAnswerUser;
use app\models\RefKomments;
use app\models\LinksSearch;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use app\models\UserHouseApartSearch;
use yii\data\ActiveDataProvider;
use app\modules\sending\models\SendingDeliveryStatus;
use app\modules\sending\models\Sending;
use app\modules\sending\models\DictPollAnswers;
use app\models\PollTextAddition;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionNews($id = null)
    {

        if ($id === null) {
            return $this->redirect('all-news');
        }
        $result = '';
        $stream = Stream::find()->all();
        if ($stream) {
            foreach ($stream as $camera) {
                $result .= '<p>';
                $result .= ClipboardJsWidget::widget([
                    'text' => trim($camera->bodyStream),
                    'label' => 'Скопировать ссылку на трансляцию: ' . $camera->cameraName,
                    'successText' => 'Скопировано',
                    'htmlOptions' => [
                        'class' => 'btn btn-primary',
                    ],
                ]);
                $result .= '</p>';
            }
        };
        $model = $this->findModel($id);

        $repResult = str_replace('{ссылки потоков}', $result, $model->page);

        return $this->render('news', [
            'model' => $model,
            'repResult' => $repResult,
        ]);
    }

    public function actionAddKomment($id)
    {
        $model = new RefKomments();
        $model->moderation = 0;

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $this_answer = new RefAnswerUser();
            $this_answer->voting_result = 2;
            $this_answer->komment = $model->id;
            $this_answer->user_id = Yii::$app->user->id;
            $this_answer->save();
            return $this->redirect('index');

        }

        return $this->renderAjax('add-komment', [
            'model' => $model,
        ]);


    }

    public function actionIndex()
    {


        $userId = Yii::$app->user->id;

        $userProblems = RefProblemsUser::find()->select('ref_problems_id')->andWhere(['user_id' => $userId])->column();
        $userAnswer = RefAnswerUser::find()->select('ref_answer_id')->andWhere(['user_id' => $userId])->column();


        if (!$userProblems) {
            $no_voiting_problems = RefProblems::find()->one();


        } else {
            $no_voiting_problems = RefProblems::find()
                ->andWhere(['not in', 'id', RefProblemsUser::find()->select('ref_problems_id')->andWhere(['user_id' => $userId])])->one();

        }

        $new_voice_problem = new RefProblemsUser();
        if ($new_voice_problem->load(Yii::$app->request->post())) {
            $new_voice_problem->user_id = Yii::$app->user->id;
            $new_voice_problem->ref_problems_id = $no_voiting_problems->id;
        }

        if ($new_voice_problem->load(Yii::$app->request->post()) && $new_voice_problem->save()) {
            if (isset($rating)) {
                $this_rating = $rating->rating;
                $rating->rating = $this_rating + 10;
                $rating->save();
                Yii::$app->session->SetFlash('success', 'Вам добавлено 10 баллов. Ваш текущий рейтинг: ' . $rating->rating);

            } else {
                $rating = new RefActivity();
                if ($rating->load(Yii::$app->request->post()) && $rating->save()) {
                    $rating->user_id = Yii::$app->user->id;
                    $rating->rating = 10;
                    $rating->save();
                    Yii::$app->session->SetFlash('success', 'Вам добавлено 10 баллов. Ваш текущий рейтинг: ' . $rating->rating);
                }
            }
            return $this->redirect('index');

        }

        if (!$userAnswer) {

            $no_voiting_answer = RefAnswer::find()->one();
        } else {

            $no_voiting_answer = RefAnswer::find()->andWhere(['not in', 'id', RefAnswerUser::find()->select('ref_answer_id')->andWhere(['user_id' => $userId])])->one();
        }


        $new_voice_answer = new RefAnswerUser();
        if (isset($new_voice_answer) && isset($no_voiting_answer)) {
            $new_voice_answer->user_id = Yii::$app->user->id;
            $new_voice_answer->ref_answer_id = $no_voiting_answer->id;
        }

        if ($new_voice_answer->load(Yii::$app->request->post()) && $new_voice_answer->save()) {
            return $this->redirect('index');
        }


        $hot_news = News::find()->where(['status' => 1])->limit('9')->orderBy(['date_of_publication' => SORT_DESC])->all();


        return $this->render('index', [
            'hot_news' => $hot_news,
            'no_voiting_problems' => $no_voiting_problems,
            'no_voiting_answer' => $no_voiting_answer,
            'new_voice_problem' => $new_voice_problem,
            'new_voice_answer' => $new_voice_answer,
        ]);
    }

    public function actionAllNews()
    {
        $model = News::find()->andWhere(['status' => 1])->orderBy(['date_of_publication' => SORT_DESC])->all();
        $result = '';
        $c = 0;
        $month = ["01" => "января", "02" => "февраля", "03" => "марта", "04" => "апреля", "05" => "мая", "06" => "июня", "07" => "июля", "08" => "августа",
            "09" => "сентября", "10" => "октября", "11" => "ноября", "12" => "декабря"];

        foreach ($model as $key => $hotNewsAll) {
            if ($c % 3 == 0) {
                $result .= '<div class="row p-30"> ';
            }
            $result .= '<div class="col-md-4">';
            $result .= '<h4>' . Html::a($hotNewsAll->h1, ['news', 'id' => $hotNewsAll->id]) . '</h4>';
            $result .= '<p>' . $hotNewsAll->description . '</p>';
            $result .= '<p><i>' . \Yii::$app->formatter->asDate(strtotime($hotNewsAll->date_of_publication), 'php:d')
                . ' '
                . $month[Yii::$app->formatter->asDate(strtotime($hotNewsAll->date_of_publication), 'php:m')]
                . ' '
                . \Yii::$app->formatter->asDate(strtotime($hotNewsAll->date_of_publication), 'php:Y')
                . '</i></p>';
            $result .= '</div>';
            if ($c % 3 == 2) {

                $result .= '</div>';
            }
            $c++;

        }

        if (!$result) {
            $result = 'Нет новостей';
        }


        return $this->render('all-news', ['result' => $result]);
    }

    public function actionStartCategory()
    {

        if (!Yii::$app->user->can('chief')) {
            throw new HttpException(404, 'Такой страницы не сущестует');
        }

        $allHouse = DictHouses::find()->all();

        foreach ($allHouse as $house) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $newCategory = new DictSendingUserCategory();
                $newCategory->name = 'Дольщики дома №' . $house->name;

                if (!$newCategory->save()) {
                    throw new Exception('Ошибка при сохранении группы');
                }

                $users = UserHouseApart::find()->andWhere(['house_id' => $house->id])->all();

                foreach ($users as $user) {
                    $userCategory = new SendingUserCategory();
                    $userCategory->category_id = $newCategory->id;
                    $userCategory->user_id = $user->user_id;

                    if (!$userCategory->save()) {
                        throw new Exception('Ошибка при сохранении сопоставления');

                    }
                }


            } catch (Exception $e) {

                $transaction->rollBack();

                throw $e;
            }

            $transaction->commit();

        }

        return 'Категории созданы';
    }

    public function actionAddToSendingNewUserHouse($sendingId)
    {

        if (!Yii::$app->user->can('chief')) {
            throw new HttpException(404, 'Такой страницы не сущестует');
        }

        $sending = Sending::find()->andWhere(['id' => $sendingId])->one();

        $houseId = $sending->house_id ?? 0;

        $persentUserHouseCategory = UserHouseApart::find()
            ->andWhere(['house_id' => $houseId])
            ->andWhere(['not in', 'user_id', SendingDeliveryStatus::find()
                ->select('user_id')
                ->andWhere(['sending_id' => $sendingId])
                ->column()])->all();

        if ($persentUserHouseCategory) {
            foreach ($persentUserHouseCategory as $item) {
                $newUserCategory = new SendingUserCategory();
                $newUserCategory->category_id = $sending->sending_category_id;
                $newUserCategory->user_id = $item->user_id;

                if (!$newUserCategory->save()) {
                    throw new \Exception('Ошибка при сохранении ', print_r($newUserCategory->errors));
                }

                return $this->redirect(['/sending/send/start-sending', 'sendId' => $sendingId]);


            }
        }


    }

    public function actionDeliveryStatus($typeEvent = null, $value = null, $typeOfLetter = null, $sendingId = null)
    {
        if (!Yii::$app->user->can('chief')) {
            throw new HttpException(404, 'Такой страницы не сущестует');
        }

        if ($sendingId === null) {
            $template = DictSendingTemplate::find()
                ->andWhere(['base_type' => $typeOfLetter])
                ->one();
            $sending = Sending::find()
                ->andWhere(['type_id' => $typeEvent])
                ->andWhere(['value' => $value])
                ->andWhere(['template_id' => $template->id])
                ->one();
        } else {
            $sending = Sending::find()->andWhere(['id' => $sendingId])->one();
        }

        if (!$sending) {
            throw new HttpException('404', 'Такой страницы не существует');
        }

        if (!SendingDeliveryStatus::find()->andWhere(['sending_id' => $sending->id])->exists()) {
            Yii::$app->session->setFlash('warning', 'Рассылка еще не была осуществлена, так как находится на модерации!');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => SendingDeliveryStatus::find()->andWhere(['sending_id' => $sending->id]),
            'sort' => false,
            'pagination' => false,
        ]);

        return $this->render('delivery-status', [
            'dataProvider' => $dataProvider,
            'sendingId' => $sendingId,
        ]);

    }

    public function actionActualVote()
    {
        $vote = Polls::find()->all();

        return $this->render('actual-vote', ['vote' => $vote]);
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public
    function actionLogin()
    {
        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();
        }

        $model = new Login();

        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {


            return $this->redirect('profile');

        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public
    function actionAddVoicePlus($id)
    {
        $model = new RefAnswerUser();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $all_interest_holders = Profiles::find()->andWhere(['confirm' => true])->count();
        $this_profile = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        $this_user_id = Yii::$app->user->id;


        $house_interest_holders = Profiles::find()->andWhere(['=', 'house_id', $this_profile->house_id])->andWhere(['confirm' => true])->count();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->ref_answer_id = $id;
            $model->voting_result = 1;
            $model->save(false);

            $rating = new RefActivity();
            $rating->user_id = $this_user_id;
            $rating->ref_answer_id = $id;
            $rating->ball = RefActivity::VOITING_FOR_ANSWER;
            $rating->save(false);
            Yii::$app->session->setFlash('success', 'Спасибо Ваш, голос учтен. К своему рейтингу вы получили дополнительно' . RefActivity::VOITING_FOR_ANSWER . 'балла(ов)');


            $agree_interest_holders = RefAnswerUser::find()->andWhere(['ref_answer_id' => $id])->andWhere(['voting_result' => 1])->count();


            if (($house_interest_holders / 2) < $agree_interest_holders) {
                $legasy = RefAnswer::find()->andWhere(['id' => $id])->one();
                $legasy->legasy_status = 1;
                $legasy->save(false);
            };
            if (($all_interest_holders / 2) < $agree_interest_holders) {
                $legasy = RefAnswer::find()->andWhere(['id' => $id])->one();
                $legasy->legasy_status = 2;
                $legasy->save(false);
            };

            return $this->redirect('index');
        }
        return $this->renderAjax('add-voice-plus', [
            'model' => $model,
        ]);


    }


    public
    function actionAddVoiceMinus($id)
    {
        $model = new RefAnswerUser();

        $this_user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->ref_answer_id = $id;
            $model->voting_result = 2;
            $model->save(false);

            $rating = new RefActivity();
            $rating->user_id = $this_user_id;
            $rating->ref_answer_id = $id;
            $rating->ball = RefActivity::VOITING_FOR_ANSWER;
            $rating->save(false);
            Yii::$app->session->setFlash('success', 'Спасибо Ваш, голос учтен. К своему рейтингу вы получили дополнительно' . RefActivity::VOITING_FOR_ANSWER . 'балла(ов)');

            return $this->redirect('index');
        }
        return $this->renderAjax('add-voice-minus', [
            'model' => $model,
            'id' => $id,
        ]);


    }

    public
    function actionAllProblems()
    {
        $dolshik = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        if (Yii::$app->user->isGuest or $dolshik->confirm == false) {
            return $this->goHome();
        }
        $problems = RefProblems::find()->andWhere(['OR', ['user_id' => Yii::$app->user->id], ['moderation' => true]])->all();
        return $this->render('all-problems', [
            'problems' => $problems,]);
    }


    public
    function actionAddProblems()
    {
        $dolshik = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        if (Yii::$app->user->isGuest or $dolshik->confirm == false) {
            return $this->goHome();
        }
        $model = new RefProblems();
        $model->user_id = Yii::$app->user->id;
        $model->moderation = 0;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('all-problems');
        }

        return $this->render('add-problems', [
            'model' => $model,
        ]);
    }

    public
    function actionAddSolution($id)
    {
        $dolshik = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        if (Yii::$app->user->isGuest or $dolshik->confirm == false) {
            return $this->goHome();
        }

        $solution = RefAnswer::find()->andWhere(['ref_problems_id' => $id])->andWhere(['author_id' => Yii::$app->user->id])->one();

        if ($solution) {
            $model = $solution;
        } else {
            $model = new RefAnswer();
        }
        $model->author_id = Yii::$app->user->id;
        $problem = RefProblems::find()->andWhere(['id' => $id])->one();
        $model->ref_problems_id = $problem->id;
        $model->date_start = Date('Y-m-d H:i:s');
        $model->date_finish = Date('Y-m-d H:i:s', strtotime("+1 week"));
        $model->legasy_status = 0;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $rating = new RefActivity();
            $rating->user_id = $model->author_id;
            $rating->ref_answer_id = $id;
            $rating->ball = RefActivity::GET_ANSWER;
            $rating->save(false);

            $solution = RefAnswer::find()->andWhere(['author_id' => Yii::$app->user->id])->andWhere(['ref_problems_id' => $id])->one();

            return $this->redirect(['add-members', 'id' => $solution->id]);
        }
        return $this->render('add-solution', [
            'model' => $model,
            'problem' => $problem,
        ]);
    }

    public
    function actionAddMembers($id, $new_position = null)
    {
        $dolshik = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        $solution = RefAnswer::find()->andWhere(['id' => $id])->andWhere(['author_id' => Yii::$app->user->id])->one();
        if (Yii::$app->user->isGuest or $dolshik->confirm == false) {
            return $this->goHome();
        }

        if (!$solution) {
            Yii::$app->session->setFlash('error', 'Произошла ошибка попробуйте пройти процедуру добавления еще раз!');
            return $this->redirect('all-problems');

        }

        $model = new RefMembers();
        $model->ref_answer_id = $id;
        $model->user_id = Yii::$app->user->id;
        $searchModel = new RefMembersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['ref_answer_id' => $id])->OrderBy(['id' => SORT_DESC]);
        if ($new_position) {
            $model->doljnost_id = $new_position;
        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Должность добавлена!');


        }
        return $this->render('add-members', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    public
    function actionAddPositions($id)
    {
        $dolshik = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        if (Yii::$app->user->isGuest or $dolshik->confirm == false) {
            return $this->goHome();
        }
        $model = new RefDoljnost();
        $model->ref_answer_id = $id;
        $model->user_id = Yii::$app->user->id;
        $model->moderation = 0;

        //  if(﻿Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) &&  $model->validate() && $model->save())
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['add-members', 'id' => $id, 'new_position' => $model->id]);
        } else {
            return $this->renderAjax('add-position', [
                'model' => $model,
            ]);
        }


    }

    public
    function actionDol($id)
    {
        $model = RefDoljnost::findOne($id);
        echo $model->description;

    }

    public
    function actionDeleteMember($id)
    {
        $dolshik = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        if (Yii::$app->user->isGuest or $dolshik->confirm == false) {
            return $this->goHome();
        }

        $answer_id = RefMembers::find()->andWhere(['id' => $id])->one();
        RefMembers::findOne($id)->delete();
        return $this->redirect(['add-members', 'id' => $answer_id->ref_answer_id]);

    }

    public
    function actionFullText($id)
    {
        $dolshik = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        if (Yii::$app->user->isGuest or $dolshik->confirm == false) {
            return $this->goHome();
        }

        $model = RefProblems::findOne($id);

        return $this->render('full-text', [
            'model' => $model,
        ]);
    }

    public
    function actionFullTextAjax($id)
    {
        $dolshik = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        if (Yii::$app->user->isGuest or $dolshik->confirm == false) {
            return $this->goHome();
        }


        $model = RefProblems::findOne($id);

        return $this->renderAjax('full-text', [
            'model' => $model,
        ]);
    }

    public
    function actionFullTextAnsAjax($id)
    {
        $dolshik = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        if (Yii::$app->user->isGuest or $dolshik->confirm == false) {
            return $this->goHome();
        }

        $model = RefAnswer::findOne($id);

        return $this->renderAjax('full-text-ans', [
            'model' => $model,
        ]);
    }

    public
    function actionUpdateProblem($id)
    {
        $dolshik = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        if (Yii::$app->user->isGuest or $dolshik->confirm == false) {
            return $this->goHome();
        }


        $model = RefProblems::findOne($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (!($model->user_id == Yii::$app->user->id)) {
            Yii::$app->session->setFlash('error', 'Вы не можете редактировать эту проблему, так как не вы ее создали');

            return $this->redirect('all-problems');
        }

        if ($model->moderation == true) {
            Yii::$app->session->setFlash('error', 'Вы не можете редактировать эту проблему, так как она прошла модерацию');

            return $this->redirect('all-problems');
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect('all-problems');

        }
        return $this->render('update-problem', [
            'model' => $model,
        ]);
    }

    public
    function actionDeleteProblem($id)
    {
        $dolshik = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        if (Yii::$app->user->isGuest or $dolshik->confirm == false) {
            return $this->goHome();
        }

        RefProblems::findOne($id)->delete();

        return $this->redirect(['all-problems']);

    }


    public
    function actionInterestBearerConfirm()
    {
        if (!Yii::$app->user->can('chief')) {
            throw new HttpException(404, 'Такой страницы не существует!');
        }

        $currentHouseApart = UserHouseApart::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        $house = DictHouses::find()->select('name')->indexBy('id')->column();
        $user = User::find()->select('username')->indexBy('id')->column();
        $currentProfile = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();


        $searchModel = new UserHouseApartSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($currentHouseApart) {
            $dataProvider->query
                ->with('profile')
                ->andWhere(['house_id' => $currentHouseApart->house_id])
                ->orderBy(['confirm' => SORT_ASC]);

        }
        $dataProvider->pagination = false;


        return $this->render('interest-bearer-confirm', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'house' => $house,
            'user' => $user,
            'currentProfile' => $currentProfile,
        ]);

    }


    public
    function actionIbConfirm($userId, $houseId, $apartNumber, $cancel = null)
    {
        $profile = UserHouseApart::find()->andWhere(['user_id' => $userId])->andWhere(['house_id' => $houseId, 'apart_number'=> $apartNumber])->one();
        $profile_chief = UserHouseApart::find()->andWhere(['user_id' => Yii::$app->user->id])->one();
        $profile->scenario = UserHouseApart::SCENARIO_CONFIRM;
        if ($profile->house_id == $profile_chief->house_id && $cancel == null) {
            $profile->confirm = 1;
        } else {
            $profile->confirm = 0;
            $usrCategory = SendingUserCategory::find()
                ->andWhere(['user_id' => $profile->user_id])
                ->andWhere(['category_id' => $profile->userCategory->id])->one();

            if ($usrCategory) {
                $usrCategory->delete();
            }

        }
        if ($profile->save()) {
            if (!SendingUserCategory::find()
                    ->andWhere(['user_id' => $profile->user_id])
                    ->andWhere(['category_id' => $profile->userCategory->id])
                    ->exists() && !$cancel) {
                $newUser = new SendingUserCategory();
                $newUser->category_id = $profile->userCategory->id;
                $newUser->user_id = $profile->user_id;

                if (!$newUser->save()) {
                    throw new Exception('Ошибка при сохранении пользователя в группу своего дома');
                }
            };
        };


        if ($profile->save()) {
            return $this->redirect('interest-bearer-confirm');
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public
    function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('login');
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */

    public
    function actionRemindLogin($email = null)
    {
        $model = User::find()->andWhere(['email' => $email])->one();

        if ($email !== null) {
            $result = $model->username;
        } else {
            $result = 'Вы не указали электронную почту';
        }

        if ($model) {
            return $this->render('remind-login', [
                'model' => $model,
                'result' => $result,
            ]);
        } else {
            return 'Вы указали несуществующую почту';
        }
    }


    public
    function actionTrip()
    {
        $typeTrip = CarpoolingTrip::typeTrip();
        $allDate = CarpoolingTrip::find()->select(["DATE_FORMAT(date, '%d.%m.%Y')"])
            ->andWhere(['>=', 'date', Date('Y-m-d')])
            ->indexBy('date')
            ->orderBy('date')
            ->column();
        $metro = DictMetro::find()->select('name')->indexBy('id')->column();

        $currentTrip = CarpoolingPassengers::find()
            ->andWhere(['user_id' => Yii::$app->user->id])
            ->andWhere(['in', 'trip_id', CarpoolingTrip::find()
                ->select(['id'])
                ->andWhere(['>=', 'date', Date('Y-m-d')])
                ->column()])
            ->andWhere(['is', 'result', NULL])
            ->all();

        $result = '';
        $maxTime = '0';

        if ($currentTrip) {

            foreach ($currentTrip as $allUserTrip) {
                $trip = CarpoolingTrip::find()->andWhere(['id' => $allUserTrip->trip_id])->one();
                $driver = Profiles::find()->andWhere(['user_id' => $trip->user_id])->one();
                $passenger = Profiles::find()->andWhere(['user_id' => $allUserTrip->user_id])->one();

                $result .= '<h3>Детали бронрования поездки: </h3>';
                $result .= '<strong>Дата поездки: </strong>' . $trip->date . '<br/>';
                $result .= '<strong>Тип поездки: </strong>' . $typeTrip[$trip->type_id] . '<br/>';
                $result .= '<strong>Водитель: </strong>' . $driver->shortFio() . ',<br/>';
                $result .= '<a class="btn btn-success mt-10" href="https://api.whatsapp.com/send?phone='
                    . $driver->phoneForWa() . '&text=Здравствуйте, '
                    . $driver->first_name
                    . ($driver->patronymic ? ' ' . $driver->patronymic : '')
                    . '! '
                    . ' Меня зовут '
                    . $passenger->first_name
                    . ($passenger->patronymic ? ' ' . $passenger->patronymic : '')
                    . ', хочу присоединиться к Вашей поездке '
                    . DateTimeToChpu::getDateChpu($trip->date)
                    . ' '
                    . $typeTrip[$trip->type_id]
                    . '">Написать водителю в WhatsApp</a> ';


                $result .= '<a class="btn btn-primary mt-10" href="tel:+'
                    . $driver->phoneForWa()
                    . '">Позвонить водителю</a> <br/><br/>';

                $result .= '<strong>Количество забронированных мест: </strong>'
                    . $allUserTrip->place . '<br/>';

                if ($trip->carpoolingMetros) {

                    if ($trip->type_id == 1 || $trip->type_id == 3) {
                        $result .= '<strong>Станции метро для посадки пассажиров: </strong><br/>';
                    } else {
                        $result .= '<strong>Станции метро для высадки пассажиров: </strong><br/>';

                    };
                    foreach ($trip->carpoolingMetros as $tripMetro) {
                        $result .= $metro[$tripMetro->metro_id];
                        $result .= ', примерное время: ';
                        $result .= DateTimeToChpu::getTimeChpu($tripMetro->time);
                        $result .= '<br/><br/>';
                        $currentTime = $tripMetro->time;
                        if (strtotime($currentTime) > strtotime($maxTime)) {
                            $maxTime = $currentTime;
                        }

                    }

                    $currentDate = Date('H:i:s', time() - 3600);


                    if ($trip->date < Date('Y-m-d') && $maxTime < $currentDate) {
                        $result .= '<p>Прошло уже больше часа с назначенного времени встречи. 
                            Состоялась ли поездка?</p>';
                        $result .= Html::a('Да', ['result-trip', 'userId' => $allUserTrip->user_id,
                            'tripId' => $allUserTrip->trip_id, 'result' => '1'], ['class' => 'btn btn-success']);
                        $result .= ' ';
                        $result .= Html::a('Нет', ['result-trip', 'userId' => $allUserTrip->user_id,
                            'tripId' => $allUserTrip->trip_id, 'result' => '0'], ['class' => 'btn btn-danger']);

                    } else {
                        $result .= '<a class="btn btn-warning" href="delete-passenger?passId=' . $passenger->user_id . '&tripId=' . $trip->id . '">Отменить бронь</a>';

                    }


                }
            }
        }


        $searchModel = new CarpoolingTripSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query
            ->andWhere(['>=', 'date', Date('Y-m-d')]);

        return $this->render('trip', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'typeTrip' => $typeTrip,
            'allDate' => $allDate,
            'metro' => $metro,
            'result' => $result,
        ]);

    }

    public
    function actionResultTrip($userId, $tripId, $result)
    {
        $model = CarpoolingPassengers::find()
            ->andWhere(['trip_id' => $tripId])
            ->andWhere(['user_id' => $userId])
            ->one();
        $model->result = $result;
        $model->save();

        if ($model->save()) {
            return $this->redirect('trip');
        }

    }


    public
    function actionDeletePassenger($passId, $tripId)
    {
        $this->findPassenger($passId, $tripId)->delete();
        return $this->redirect('trip');
    }

    protected
    function findPassenger($passId, $tripId)
    {
        $passenger = CarpoolingPassengers::find()
            ->andWhere(['user_id' => $passId])
            ->andWhere(['trip_id' => $tripId])->one();

        if ($passenger) {
            return $passenger;
        }
    }

    public
    function actionAddTrip($id = null)
    {

        if ($this->existsTripMetro($id)) {
            $nameButton = 'Завершить создание поездки';

        } else {
            $nameButton = 'Сохранить';

        };


        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('warning', 'Только зарегистрированные пользователи могут добавлять 
            или редактировать свои поездки. Пожалуйста, войдите в систему и попробуйте добавить поездку еще раз!');
            return $this->redirect('login');
        }

        if (!$this->profileExists()) {
            Yii::$app->session->setFlash('warning', 'Перед добавлением поездки необходимо заполнить сначала профиль 
            и указать номера дома и квартиры. 
            После заполнения попробуйте добавить поездку еще раз!');
            return $this->redirect('profile');

        }

        if ($id) {
            $model = CarpoolingTrip::find()->andWhere(['id' => $id])->andWhere(['user_id' => Yii::$app->user->id])->one();
        } else {

            $model = new CarpoolingTrip();
            $model->user_id = Yii::$app->user->id;

        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {


            Yii::$app->session->setFlash('success', 'Данные сохранены. Добавьте теперь, пожалуйста, 
            станции метро, возле которых сможете забрать пассажиров');
            if ($this->existsTripMetro($id)) {
                Yii::$app->session->setFlash('success', 'Поездка успешно добавлена!');
                return $this->redirect(['trip']);

            }
            return $this->redirect(['add-trip', 'id' => $model->id]);
        }

        return $this->render('add-trip', [
            'model' => $model,
            'nameButton' => $nameButton,
        ]);

    }

    public function actionAddPassenger($tripId)
    {
        if (!$this->profileExists()) {
            Yii::$app->session->setFlash('error', 'Сервис предназначен только для дольщиков нашего ЖК, 
            поэтому забронрировать могут только те, кто заполнил профиль. Пожалуйста, заполните профиль и поврорите 
            бронирование еще раз!');
            return $this->redirect('profile');
        }
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Только авторизованные пользователи могут бронировть поездки. Пожалуйста, 
            войдите в личный кабинет/зарегистрируйтесь и повторите попытку еще раз!');
            return $this->redirect('login');
        }

        $model = new CarpoolingPassengers();
        $model->user_id = Yii::$app->user->id;
        $model->trip_id = $tripId;

        $trip = CarpoolingTrip::find()->andWhere(['id' => $tripId])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Вы успешно забронировали место (места)');
            return $this->redirect('trip');
        }

        return $this->render('add-passenger', [
            'model' => $model,
            'trip' => $trip,
        ]);

    }

    protected function existsTripMetro($id)
    {
        return CarpoolingMetro::find()->andWhere(['trip_id' => $id])->exists();
    }

    public
    function actionAddMetro($id)
    {
        $model = new CarpoolingMetro();
        $model->trip_id = $id;

        $metro = DictMetro::find()->select('name')->indexBy('id')->column();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['add-trip', 'id' => $id]);

        }

        return $this->renderAjax('add-metro', [
            'model' => $model,
            'metro' => $metro,
        ]);

    }

    public
    function actionDeleteTripMetro($metro_id, $trip_id)
    {
        $this->findMetro($metro_id, $trip_id)->delete();
        Yii::$app->session->setFlash('succses', 'Запись удалена');
        return $this->redirect(['add-trip', 'id' => $trip_id]);
    }

    protected
    function findMetro($metro_id, $trip_id)
    {
        $metro = CarpoolingMetro::find()->andWhere(['metro_id' => $metro_id])->andWhere(['trip_id' => $trip_id])->one();
        if ($metro !== null) {
            return $metro;
        }
    }

    public
    function actionDeleteTrip($id)
    {
        $this->findTrip($id)->delete();
        Yii::$app->session->setFlash('success', 'Поездка удалена.');
    }

    protected
    function findTrip($id)
    {
        $trip = CarpoolingTrip::find()->andWhere(['id' => $id])->one();

        if ($trip !== null) {
            return $trip;
        }
    }


    public
    function actionRealVoteResult()
    {
        $profile = UserHouseApart::find()->andWhere(['user_id' => Yii::$app->user->id])->one();

        $photo = RealVoteResult::find()->andWhere(['user_id' => Yii::$app->user->id])->one();

        $is12House = UserHouseApart::find()->andWhere(['user_id' => Yii::$app->user->id])
            ->andWhere(['in', 'house_id', [14, 15]])->one();

        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Прежде чем загрузить фото бюллетени, необходимо 
            зарегистрироваться/войти в личный кабинет и заполнить профиль.');
            return $this->redirect('index');
        }


        if (!$this->profileExists()) {
            Yii::$app->session->setFlash('error', 'Прежде чем загрузить фото бюллетени, необходимо заполнить
            профиль.');
            return $this->redirect('profile');
        }


        if ($photo) {

            $fileName = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'vote' .
                DIRECTORY_SEPARATOR . 'vote_' . $profile->user_id . '.' . $photo->extension;
            if (file_exists($fileName)) {
                Yii::$app->session->setFlash('error', 'Вы уже загрузили фото бюллетени');
                return $this->redirect('index');
            }

        }

        $model = new RealVoteResult();
        $model->user_id = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post())) {

            $model->photo = UploadedFile::getInstance($model, 'photo');
            $model->extension = $model->photo->extension;

            $fileName = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'vote' .
                DIRECTORY_SEPARATOR . 'vote_' . $profile->user_id . '.' . $model->extension;

            if ($model->save() && file_exists($fileName)) {
                Yii::$app->session->setFlash('success', 'Спасибо! Ваше фото бюллетени сохранено в базе данных');
                return $this->redirect('index');

            }
        }

        return $this->render('real-vote-result', [
            'model' => $model,
            'is12House' => $is12House,
        ]);
    }


    public
    function actionVoteResult()
    {

        sleep(5);

        $houses = DictHouses::find()->andWhere(['not in', 'id', [7, 8, 10, 11, 22, 23, 24]])->all();

        $result = '';
        $c = 0;

        $profileBehindJsk = UserHouseApart::find()
            ->distinct()
            ->andWhere(['in', 'user_id', RealVoteResult::find()
                ->select('user_id')->andWhere(['vote_answer' => RealVoteResult::BEHIND_JSK])->column()]);

        $profileContraJsk = UserHouseApart::find()
            ->distinct()
            ->andWhere(['in', 'user_id', RealVoteResult::find()
                ->select('user_id')->andWhere(['vote_answer' => RealVoteResult::CONTRA_JSK])->column()]);


        $profileContraMoneyBehindJsk = UserHouseApart::find()
            ->distinct()
            ->andWhere(['in', 'user_id', RealVoteResult::find()
                ->select('user_id')->andWhere(['vote_answer' => RealVoteResult::CONTRA_MONEY_BEHIND_JSK])->column()]);

        $profileBehindMoney = UserHouseApart::find()
            ->distinct()
            ->andWhere(['in', 'user_id', RealVoteResult::find()
                ->select('user_id')->andWhere(['vote_answer' => RealVoteResult::BEHIND_MONEY])->column()]);

        $profileContraMoneyContraJsk = UserHouseApart::find()
            ->distinct()
            ->andWhere(['in', 'user_id', RealVoteResult::find()
                ->select('user_id')->andWhere(['vote_answer' => RealVoteResult::CONTRA_MONEY_CONTRA_JSK])->column()]);

        $profileAbstain = UserHouseApart::find()
            ->distinct()
            ->andWhere(['in', 'user_id', RealVoteResult::find()
                ->select('user_id')->andWhere(['vote_answer' => RealVoteResult::ABSTAIN])->column()]);

        $sumBehindJsk = $profileBehindJsk->count() + $profileContraMoneyBehindJsk->count();

        $sumBehindMoney = $profileBehindMoney->count();

        $sumAbstain = $profileAbstain->count();

        $sumContraJsk = $profileContraJsk->count() + $profileContraMoneyContraJsk->count();

        $sum = $sumBehindJsk + $sumBehindMoney + $sumContraJsk + $sumAbstain;

        $result .= '<div class="jumbotron jumbotron-fluid"><p><strong>Уважаемые дольщики! <br/>Для загрузки фото бюллетени можно воспользоваться ' . Html::a('cледующей формой.', ['real-vote-result']) . '</strong></p>';

        $result .= '<p class="lead">Делается это на добровольной основе и только после авторизации в системе. 
Ваш голос автоматически добавится к общей сумме и к сумме вашего дома на это странице.</p></div>';

        $result .= 'Текущая явка: ' . $sum . ' чел. <br/>';

        $result .= 'Всего за ЖСК проголосовало: ' . $sumBehindJsk . ' чел. <br/>';

        $result .= 'Всего за возврат денег (среди 12-х домов): ' . $sumBehindMoney . ' чел. <br/>';

        $result .= 'Всего воздержалось: ' . $sumAbstain . ' чел. <br/>';

        $result .= 'Всего против ЖСК проголосовало: ' . $sumContraJsk . ' чел. <br/>';


        foreach ($houses as $house) {
            if ($c % 3 == 0) {
                $result .= '<div class="row">';
            }
            $result .= '<div class="col-md-4 box">';
            if ($house->id == 14 || $house->id == 15) {

                $result .= '<h3>Дом ' . $house->name . '</h3>';

                $result .= '<p>Проголосовало за возврат денег: '
                    . UserHouseApart::find()
                        ->andWhere(['in', 'user_id', RealVoteResult::find()
                            ->select('user_id')
                            ->andWhere(['vote_answer' => RealVoteResult::BEHIND_MONEY])
                            ->column()])
                        ->andWhere(['house_id' => $house->id])
                        ->count() . ' чел.';

                $result .= '<p>Проголосовало против возврата денег и за ЖСК: '
                    . UserHouseApart::find()
                        ->andWhere(['in', 'user_id', RealVoteResult::find()
                            ->select('user_id')
                            ->andWhere(['vote_answer' => RealVoteResult::CONTRA_MONEY_BEHIND_JSK])
                            ->column()])
                        ->andWhere(['house_id' => $house->id])
                        ->count() . ' чел.';

                $result .= '<p>Проголосовало против возврата денег и против ЖСК: '
                    . UserHouseApart::find()
                        ->andWhere(['in', 'user_id', RealVoteResult::find()
                            ->select('user_id')
                            ->andWhere(['vote_answer' => RealVoteResult::CONTRA_MONEY_CONTRA_JSK])
                            ->column()])
                        ->andWhere(['house_id' => $house->id])
                        ->count() . ' чел.';

                $result .= '<p>Воздержалось: '
                    . UserHouseApart::find()
                        ->andWhere(['in', 'user_id', RealVoteResult::find()
                            ->select('user_id')
                            ->andWhere(['vote_answer' => RealVoteResult::ABSTAIN])
                            ->column()])
                        ->andWhere(['house_id' => $house->id])
                        ->count() . ' чел.';

            } else {
                $result .= '<h3>Дом ' . $house->name . '</h3>';

                $result .= '<p>Проголосовало за ЖСК: '
                    . UserHouseApart::find()
                        ->andWhere(['in', 'user_id', RealVoteResult::find()
                            ->select('user_id')
                            ->andWhere(['vote_answer' => RealVoteResult::BEHIND_JSK])
                            ->column()])
                        ->andWhere(['house_id' => $house->id])
                        ->count() . ' чел.';

                $result .= '<p>Проголосовало против ЖСК: '
                    . UserHouseApart::find()
                        ->andWhere(['in', 'user_id', RealVoteResult::find()
                            ->select('user_id')
                            ->andWhere(['vote_answer' => RealVoteResult::CONTRA_JSK])
                            ->column()])
                        ->andWhere(['house_id' => $house->id])
                        ->count() . ' чел.';

                $result .= '<p>Воздержалось: '
                    . UserHouseApart::find()
                        ->andWhere(['in', 'user_id', RealVoteResult::find()
                            ->select('user_id')
                            ->andWhere(['vote_answer' => RealVoteResult::ABSTAIN])
                            ->column()])
                        ->andWhere(['house_id' => $house->id])
                        ->count() . ' чел.';

            }

            $result .= '</div>';
            if ($c % 3 == 2) {
                $result .= '</div>';
            }

            $c++;

        }

        return $this->render('vote-result', [
            'result' => $result,
        ]);
    }

    public
    function actionSignup()
    {
        $model = new Signup();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public
    function actionAddBank()
    {
        if (Yii::$app->user->isGuest) {
            $this->goHome();
        }
        $dict_bank = DictBanks::findOne(['user_id' => Yii::$app->user->id]);
        if ($dict_bank) {
            $model = $dict_bank;

        } else {
            $model = new DictBanks();

        }

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = \Yii::$app->user->id;
            $model->moderation = DictBanks::NEED_MODERATION;
            $model->save();
            return $this->redirect('profile');
        }
        return $this->render('add-bank', ['model' => $model]);

    }

    public
    function actionMyQuestion()
    {
        if (Yii::$app->user->isGuest) {
            $this->goHome();
        }


        $model = new Questions();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = \Yii::$app->user->id;
            $model->date = date("Y-m-d H:i:s");
            $model->save();
            Yii::$app->session->setFlash('success', 'Спасибо, Ваш вопрос передан инициативной группе на обработку. Скоро мы Вам ответим!');

            return $this->redirect('index');

        }

        return $this->render('my-question', ['model' => $model]);
    }


    public
    function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect('login');
        }

        $profile = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->one();

        if ($profile) {
            $model = $profile;

        } else {
            Yii::$app->session->setFlash('success',
                'Будьте внимательны! Данные профиля заполняются один раз и больше не редактируются. Номер дома и квартиры 
    Вы сможете добавить после сохранения основных данных на этой же странице!');
            $model = new Profiles();
            $model->user_id = Yii::$app->user->id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', 'Данные сохранены.');

            return $this->redirect('profile');

        }

        $houses = DictHouses::find()->select('name')->indexBy('id')->column();


        return $this->render('profiles', ['model' => $model, 'houses' => $houses]);
    }

    public
    function actionResetPassword($token)
    {
        try {
            $model = new ResetPassword($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Новый пароль был сохранен.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public
    function actionLinks()
    {
        $searchModel = new LinksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy(['id' => SORT_DESC]);
        $dataProvider->pagination = false;

        return $this->render('links', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public
    function actionDocuments()
    {
        $searchModel = new DocumentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy(['id' => SORT_DESC]);
        $dataProvider->pagination = false;

        return $this->render('documents', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public
    function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequest();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Проверьте Вашу почту и следуйте инструкциям.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Произошла ошибка. Обратитесь к старшему по дому.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public
    function actionTasks()
    {

        return $this->render('tasks');
    }

    public
    function actionNews1()
    {

        return $this->render('news1');
    }

    public
    function actionAdvice1()
    {
        return $this->render('advice1');
    }

    public
    function actionAdvice2()
    {
        return $this->render('advice2');
    }

    public
    function actionAdvice3()
    {
        return $this->render('advice3');
    }

    public
    function actionStream($jkId = null)
    {
        $stream = '';
        $cameraEdit = '';

        if ($jkId === null) {
            $jkId = 1;
        }

        $model = Stream::find()->andWhere(['jk_id' => $jkId])->all();

        if (Yii::$app->user->can('News_redactor')) {
            $cameraEdit = Html::a('Редактировать настройки камер', '/stream/index', ['class' => 'btn btn-primary']);
        }


        if ($model) {
            foreach ($model as $camera) {
                $stream .= '<h3>' . $camera->cameraName . '</h3>';
                $stream .=
                    '<object type="application/x-shockwave-flash" data="/players/uflvplayer_500x375.swf" height="461" width="820">
    <param name="bgcolor" value="#FFFFFF"/>
    <param name="allowFullScreen" value="true"/>
    <param name="allowScriptAccess" value="always"/>
    <param name="movie" value="/players/uflvplayer_500x375.swf"/>
    <param name="FlashVars"
           value="way='
                    . trim($camera->bodyStream) .
                    '&amp;swf=http://flv-mp3.com/i/pic/uflvplayer_500x375.swf&amp;w=820&amp;h=461&amp;pic=http://&amp;autoplay=1&amp;tools=1&amp;skin=black&amp;volume=0&amp;q=&amp;comment="/>
</object>';
                $stream .= '<br/>';
                $stream .= \supplyhog\ClipboardJs\ClipboardJsWidget::widget([
                    'text' => trim($camera->bodyStream),
                    'label' => 'Скопировать ссылку на трансляцию',
                    'successText' => 'Скопировано',
                    'htmlOptions' => ['class' => 'btn btn-warning'],
                    'tag' => 'button',
                ]);

            }

        }

        return $this->render('stream', [
            'stream' => $stream,
            'cameraEdit' => $cameraEdit,
        ]);
    }

    public
    function actionAddApart()
    {
        if (Yii::$app->user->isGuest) {
            $this->goHome();
        }


        $model = new UserHouseApart();
        $model->user_id = Yii::$app->user->id;
        $model->confirm = 0;

        $houses = DictHouses::find()->select('name')->indexBy('id')->column();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('profile');
        }

        return $this->renderAjax('add-apart',
            [
                'model' => $model,
                'houses' => $houses,
            ]);


    }

    public
    function actionDeleteApart($user_id, $house_id, $apart_number)
    {
        $model = $this->findApart($user_id, $house_id, $apart_number);

        if ($model->confirm) {
            Yii::$app
                ->session
                ->setFlash('error', 'Вы не можете удалить эту запись о квартире, так как старший по этому дому уже подтвердил ее. 
                Чтобы ее удалить попросите старшего Вашего отменить подтверждение!');
            $this->redirect('profile');
        } else {
            $this->findApart($user_id, $house_id, $apart_number)->delete();
            Yii::$app->session->setFlash('success', 'Запись о квартире удалена!');
            return $this->redirect('profile');

        }
    }

    public
    function actionUpdateApart($user_id, $house_id, $apart_number)
    {
        $model = $this->findApart($user_id, $house_id, $apart_number);

        $houses = DictHouses::find()->select('name')->indexBy('id')->column();

        $model->confirm = 0;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('profile');
        }

        return $this->renderAjax('add-apart',
            [
                'model' => $model,
                'houses' => $houses,
            ]);
    }


    public function actionSavePollResult($answerId, $hash)
    {
        $model = SendingDeliveryStatus::find()->andWhere(['hash' => $hash])->one();

        $answer = DictPollAnswers::find()->andWhere(['id' => $answerId])->one();

        if ($answer->text_addition) {
            $textAddition = new PollTextAddition();

            if ($textAddition->load(Yii::$app->request->post()) && $textAddition->save($answerId, $hash)) {
                return $this->redirect(['/msg-view', 'hash' => $hash]);
            }

            return $this->render('poll-text-addition',
                ['model' => $textAddition]);

        }
        if ($model->date_time_poll_answer === null) {

            $model->date_time_poll_answer = date('Y-m-d H:i:s');
        }

        $model->poll_answer_id = $answerId;
        $model->status_id = SendingDeliveryStatus::STATUS_HAS_POLL;

        if ($model->save()) {
            return $this->redirect(['/msg-view', 'hash' => $hash]);

        }

    }

    public function actionDeletePollResult($hash)
    {
        $model = SendingDeliveryStatus::find()->andWhere(['hash' => $hash])->one();
        $model->poll_answer_id = null;

        $model->updateAttributes(['status_id' => SendingDeliveryStatus::STATUS_READ]);

        if ($model->save()) {
            return $this->redirect(['/msg-view', 'hash' => $hash]);

        }
    }

    public function actionAllMsg()
    {

        if (!Yii::$app->user->id) {
            return $this->redirect('/login');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => SendingDeliveryStatus::find()
                ->andWhere(['sending_delivery_status.user_id' => Yii::$app->user->id]),
            'pagination' => false,
        ]);


        return $this->render('all-msg',
            ['dataProvider' => $dataProvider]);

    }

    public function actionMsgView($hash)
    {
        $msg = SendingDeliveryStatus::find()->andWhere(['hash' => $hash])->one();
        if (!$msg) {
            throw new HttpException('404', 'Страницы не существует');
        }

        if ($msg->status_id !== SendingDeliveryStatus::STATUS_HAS_POLL) {
            $msg->updateAttributes(['status_id' => SendingDeliveryStatus::STATUS_READ]);
        }

        $allTheme = Sending::find()->select('name')->indexBy('id')->column();

        $currentTheme = $allTheme[$msg->sending_id];

        $letter = Sending::getLetter($msg->sending_id, $msg->user_id, Sending::TYPE_HTML, $hash);


        return $this->render('msg-view', [
            'letter' => $letter,
            'currentTheme' => $currentTheme,
            'msg' => $msg,
        ]);

    }

    public function actionBee()
    {
        return $this->render('bee');
    }


    public function actionNotice()
    {
        return 'Сайт закрыт на техническое обслуживание. Зайдите, пожалуйста, позже!';
    }

    protected
    function findApart($userId, $houseId, $apartNum)
    {
        $useApart = UserHouseApart::find()
            ->andWhere(['user_id' => $userId])
            ->andWhere(['house_id' => $houseId])
            ->andWhere(['apart_number' => $apartNum])
            ->one();
        if ($useApart !== null) {
            return $useApart;
        }
        throw new NotFoundHttpException('Страницы не существует');

    }

    protected
    function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страницы не существует.');
    }

    private
    function profileExists()
    {
        $profile = Profiles::find()->andWhere(['user_id' => Yii::$app->user->id])->exists();
        $flat = UserHouseApart::find()->andWhere(['user_id' => Yii::$app->user->id])->exists();

        if ($profile !== null && $flat !== null) {
            return $flat;
        }
    }

}
