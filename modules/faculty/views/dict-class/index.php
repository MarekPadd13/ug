<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DictClassSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Классы/курсы';
$this->params['breadcrumbs'][] = $this->title;

$typeOfClasses = \app\models\DictClass::typeOfClass();
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
            [
//                'attribute' => '',
                'value' => function ($model) use ($typeOfClasses) {
                    return $model->name.'-й '.$typeOfClasses[$model->type];
                },
                'filter' => $typeOfClasses,
            ],


            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>
</div>
