<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\DictDiscipline;
use app\models\DictCompetitiveGroup;
use yii\helpers\ArrayHelper;
use app\models\DictSpeciality;
use app\models\DictSpecialization;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DisciplineCompetitiveGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дисциплины и конкурсные группы';
$this->params['breadcrumbs'][] = $this->title;

$specialityId = ArrayHelper::map(DictSpeciality::find()->all(), 'id', 'name');
$specializationId = ArrayHelper::map(DictSpecialization::find()->all(), 'id', 'name');
$form_edu = ['1'=> 'Очная', '2'=> 'Очно-заочная', '3'=> 'Заочная'];
$edu_level = ['1'=> 'БАК', '2'=> 'МАГ', '3'=> 'АСП'];

$disciplineId = ArrayHelper::map(DictDiscipline::find()->all(), 'id', 'name');

$cgid  = ArrayHelper::map(DictCompetitiveGroup::find()->all(), 'id', function($model) use($specialityId,
    $specializationId, $form_edu, $edu_level){
    return
        $edu_level[$model->edu_level]
        ." / ".$specialityId[$model->speciality_id]
        . " / ".$specializationId[$model->specialization_id]
        . " / ".$form_edu[$model->education_form_id];})

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

            ['attribute' => 'discipline_id',
                'format' => 'raw',
                'value' => function ($model) use ($disciplineId) {
                    return $disciplineId[$model->discipline_id];
                },
                'filter' => $disciplineId,
            ],

            ['attribute' => 'competitive_group_id',
                'format' => 'raw',
                'value' => function ($model) use ($cgid) {
                    return $cgid[$model->discipline_id];
                },
                'filter'=> $cgid,
            ],

            'priority',

            ['class' => 'yii\grid\ActionColumn', 'template'=> '{update} {delete}'],
        ],
    ]); ?>
</div>
