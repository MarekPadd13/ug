<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MasterClassSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-class-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'master_id') ?>

    <?= $form->field($model, 'aud_number') ?>

    <?= $form->field($model, 'time_start') ?>

    <?php // echo $form->field($model, 'time_finish') ?>

    <?php // echo $form->field($model, 'dod_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
