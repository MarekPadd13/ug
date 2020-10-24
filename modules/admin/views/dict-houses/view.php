<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DictHouses */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Дома', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-angle-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'flat_count',
            'moderationName',
            'deadline'
        ],
    ]) ?>
    <?php if($model->getDataEndHomeBuild()->count()): ?>

    <?= \app\widgets\ChartWidget::widget(['model'=> $model, 'url' => ['/admin/dict-houses/view', 'id' => $model->id]]); ?>

    <?php endif; ?>

    <div class="dict-angle-view">

        <h3>Степень готовоности</h3>

        <p>
            <?= Html::a('Создать', ['end-home-build/create', 'home_id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>

      <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider(['query' => $model->getDataEndHomeBuild()->orderBy(['date'=>SORT_DESC])]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'number',
            'date',
            ['class' => 'yii\grid\ActionColumn', 'controller'=> 'end-home-build',  'template' => '{delete} {update}', 'buttons' => [
                'update' => function ($url, $model, $key) {return Html::a('Обновить', ['end-home-build/update', 'id' => $model->id, 'home_id' => $model->home_id]);},
            ]],
        ],
    ]); ?>
    </div>
</div>
