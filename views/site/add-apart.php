<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

?>


<?php $form = ActiveForm::begin(); ?>

<?=$form->field($model, 'type')->dropDownList(\app\models\UserHouseApart::types()); ?>

<?=$form->field($model, 'house_id')->widget(Select2::className(), [
    'data' => $houses,
    'options' => ['placeholder' => 'Выберите дом'],
    'pluginOptions' => [
        'allowClear' => true,
    ]

]); ?>

<?=$form->field($model, 'entrance')->textInput(['type' => 'number']); ?>

<?=$form->field($model, 'floor')->textInput(['type' => 'number']); ?>

<?=$form->field($model, 'apart_number')->textInput(['type' => 'number']); ?>

<?=$form->field($model, 'sq')->textInput(); ?>


<?=Html::submitButton('Добавить', ['class' => 'btn btn-success']); ?>

<?php ActiveForm::end() ?>



