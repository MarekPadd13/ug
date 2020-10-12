<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OlimpiadsTypeTemplatesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="olimpiads-type-templates-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'number_of_tours') ?>

    <?= $form->field($model, 'event_type_olimp') ?>

    <?= $form->field($model, 'form_of_passage') ?>

    <?= $form->field($model, 'edu_level_olimp') ?>

    <?= $form->field($model, 'template_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
