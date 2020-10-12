<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OlimpicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Олимпиады/конкурсы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
//            'event_type',
//            'chairman_id',
//            'number_of_tours',
            //'form_of_passage',
            //'edu_level_olymp',
            //'date_time_start_reg',
            //'date_time_finish_reg',
            //'time_of_distants_tour',
            //'date_time_start_tour',
            //'address:ntext',
            //'time_of_tour',
            //'requiment_to_work_of_distance_tour:ntext',
            //'requiment_to_work:ntext',
            //'criteria_for_evaluating_dt:ntext',
            //'criteria_for_evaluating:ntext',
            //'showing_works_and_appeal',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update} {delete} {tests} {questions}',
                'buttons' => [
                    'tests' => function ($url, $model, $key) {
                        return Html::a(
                            'Т',
                            Url::toRoute(
                                ['/test/test', 'olimpicId' => $model->id]
                            ),
                            [
                                'title' => 'Тесты',
                                'data-pjax' => '0',
                                'target' => '_blank',
                            ]
                        );
                    },
                    'questions' => function ($url, $model, $key) {
                        return Html::a(
                            'В',
                            Url::toRoute(
                                ['/test/question', 'olimpicId' => $model->id]
                            ),
                            [
                                'title' => 'Вопросы',
                                'data-pjax' => '0',
                                'target' => '_blank',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
