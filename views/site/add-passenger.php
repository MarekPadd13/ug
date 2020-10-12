<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]) ?>

<?= $form->field($model, 'place')->dropDownList($trip->dropDownVacant()); ?>

<?= Html::submitButton('Забронировать', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>
