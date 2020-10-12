<?php

use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use kartik\datetime\DateTimePicker;

/**
 * @var $dictTemplate
 * @var $dictUserCategory
 * @var $model
 */

$polls = \app\modules\sending\models\Polls::getAllPolls();

$form = ActiveForm::begin(['id' => 'create-sending', 'options' => ['autocomplete' => 'off']]);

echo $form->field($model, 'name')->textInput(['maxlength' => true]);

echo $form->field($model, 'sending_category_id')->widget(Select2::className(), [
    'data' => $dictUserCategory,
    'options' => ['placeholder' => 'Выберите категорию'],
    'pluginOptions' => [
        'allowClear' => true,
    ],

]);

echo $form->field($model, 'template_id')->widget(Select2::className(), [
    'data' => $dictTemplate,
    'options' => ['placeholder' => 'Выберите шаблон'],
    'pluginOptions' => [
        'allowClear' => true,
    ],

]);

echo $form->field($model, 'deadline')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Введите дату и время ...'],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy.mm.dd hh:ii',
        'startDate' => "+1d",
    ],
]);

echo $form->field($model, 'kind_sending_id')
    ->dropDownList(['' => ''] + \app\modules\sending\models\Sending::KIND_OF_SENDING);


echo $form->field($model, 'poll_id')->widget(Select2::className(), [
    'data' => $polls,
    'options' => ['placeholder' => 'Выберите опрос'],
    'pluginOptions' => [
        'allowClear' => true,
    ],

]);

echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']);

ActiveForm::end();