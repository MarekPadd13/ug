<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\HomeImage */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Фото домов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-answer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= $model->status ? Html::a('Снять', ['status', 'id' => $model->id, 'status'=> $model::STATUS_DEFAULT],
         ['class' => 'btn btn-warning', 'data-method'=>'post']) :
            Html::a('Опубликовать', ['status', 'id' => $model->id, 'status'=> $model::STATUS_PUBLISHED], ['class' => 'btn btn-warning', 'data-method'=>'post']) ?>
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
            'statusName',
            'angle.name',
            'home.name',
            'link',
            'date:date',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <?= Html::img($model->getImageFileUrl('image')); ?>

</div>
