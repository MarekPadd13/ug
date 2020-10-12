<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;


$this->title = 'Загрузка фото бюллетени';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin() ?>

<h1><?= $this->title ?></h1>

<?= $form->field($model, 'vote_answer')->dropDownList(['' => ''] + ($is12House ? $model->voteResult12() : $model->voteResult())) ?>

<?= $form->field($model, 'photo')->fileInput(); ?>

<?= $form->field($model, 'vote')->textInput(); ?>


<?= $form->field($model, 'agree')->checkbox() ?>

<?= Html::submitButton('Загрузить', ['class' => 'btn btn-warning']); ?>


<?php ActiveForm::end() ?>


