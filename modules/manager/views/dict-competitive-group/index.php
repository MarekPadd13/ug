<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\DictSpeciality;
use app\models\DictFaculty;
use app\models\DictSpecialization;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DictCompetitiveGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Конкурсные группы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    $specialityId = ArrayHelper::map(DictSpeciality::find()->all(), 'id', 'code');
    $specializationId = ArrayHelper::map(DictSpecialization::find()->orderBy('name')->all(), 'id', 'name');
    $faculty = ArrayHelper::map(DictFaculty::find()->all(), 'id', 'full_name');
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            [
                'attribute' => 'speciality_id',
                'format' => 'raw',
                'value' => function ($model) use ($specialityId) {
                    return $specialityId[$model->speciality_id];
                },
                'filter' => $specialityId,

            ],
            [
                'attribute' => 'specialization_id',
                'format' => 'raw',
                'value' => function ($model) use ($specializationId) {
                    return $specializationId[$model->specialization_id];
                },
                'filter' => $specializationId,

            ],


            [
                'attribute' => 'faculty_id',
                'format' => 'raw',
                'value' => function ($model) use ($faculty) {
                    return $faculty[$model->faculty_id];
                },
                'filter' => $faculty,

            ],
//            'edu_level',
//            'education_form_id',
            //'financing_type_id',
            //'faculty_id',
            //'kcp',
            //'special_right_id',
            //'competition_count',
            //'passing score',
            //'link',
            //'is_new_program',
            //'only_pay_status',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>
</div>
