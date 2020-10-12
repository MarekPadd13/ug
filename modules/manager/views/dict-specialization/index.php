<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\DictSpeciality;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DictSpecializationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Образовательные программы';
$this->params['breadcrumbs'][] = $this->title;

$specialityId = ArrayHelper::map(DictSpeciality::find()->all(), 'id', 'code');

?>


<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',

            [
                'attribute' => 'speciality_id',
                'format' => 'raw',
                'value' => function ($model) use ($specialityId) {
                    return $specialityId[$model->speciality_id];
                },
                'filter' => $specialityId,

            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>
</div>
