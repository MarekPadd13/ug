<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

?>


<?php $form = ActiveForm::begin(); ?>

<?=$form->field($model, 'metro_id')->widget(Select2::className(), [
    'data' => $metro,
    'options' => ['placeholder' => 'Выберите станцию метро'],
    'pluginOptions' => [
        'allowClear' => true,
    ]

]); ?>

<?=$form->field($model, 'time')->widget(\yii\widgets\MaskedInput::className(),[
    'mask'=> '99:99',
]);

?>


<?=Html::submitButton('Добавить', ['class' => 'btn btn-primary']); ?>

<?php ActiveForm::end() ?>



