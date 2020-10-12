<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'email')->textInput(); ?>

<?= Html::submitButton('Напомнить', ['class' => 'btn btn-primary']) ?>
