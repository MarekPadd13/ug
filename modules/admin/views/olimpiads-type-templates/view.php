<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\OlimpiadsTypeTemplates */

$this->title = $model->number_of_tours;
$this->params['breadcrumbs'][] = ['label' => 'Olimpiads Type Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'number_of_tours' => $model->number_of_tours, 'form_of_passage' => $model->form_of_passage, 'edu_level_olimp' => $model->edu_level_olimp, 'template_id' => $model->template_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'number_of_tours' => $model->number_of_tours, 'form_of_passage' => $model->form_of_passage, 'edu_level_olimp' => $model->edu_level_olimp, 'template_id' => $model->template_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'number_of_tours',
            'form_of_passage',
            'edu_level_olimp',
            'template_id',
        ],
    ]) ?>

</div>
