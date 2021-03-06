<?php

use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\file\FileInput;
use app\models\DictAngle;
use app\models\DictHouses;

/* @var $this yii\web\View */
/* @var $model \app\modules\admin\form\HomeImageForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form">
    <?php $form = ActiveForm::begin([
        'id' => 'image-form',
    'options' => [
        'enctype' => 'multipart/form-data',
    ]]); ?>
    <?php if(!Yii::$app->request->get('angle_id')): ?>
    <?= $form->field($model, 'angle_id')->widget(Select2::class, [
        'data' => ['0'=>'Ракурс не найден']+DictAngle::allColumn(),
        'options' => ['placeholder' => 'Ракурсы'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
        'pluginEvents' => [
            'change' => 'function(e) { 
                if(e.currentTarget.value == 0) {
                   $("#angle_new").show();
                 } 
                 else {
                  $("#angle_new").hide();
                 }
            }',
        ]
    ]) ?>

    <div id="angle_new">
        <?= $form->field($model, 'name')->textInput() ?>
    </div>

    <?php endif; ?>
    <?php if(!Yii::$app->request->get('home_id')): ?>
    <?= $form->field($model, 'home_id')->widget(Select2::class, [
        'data' => DictHouses::allColumn(),
        'options' => ['placeholder' => 'Укажите номер дома'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>
    <?php endif; ?>
    <?= $form->field($model, 'description')->label('Краткое описание изменений (если их нет, то поле можно оставить пустым)')->textarea() ?>

    <?= $form->field($model, 'link')->textInput() ?>

    <?= $form->field($model, 'image')->widget(FileInput::class, [
        'options' => ['accept' => 'image/*'],
    ])?>

    <?= $form->field($model, 'date')->widget(DatePicker::class, [
            'pluginOptions' => [
                'endDate' => '+0d',
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]]); ?>

    <?= $form->field($model, 'date_visible')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs(<<<JS
"use strict";
var angleNew = $('#angle_new');
var select = $('#homeimageform-angle_id');
select.on("change init", function() {
    angleNew.find('input').val('');
    if (this.value == 0) {
        angleNew.show();
    } else {
        angleNew.hide();
    }
    if (this.value == "") {  angleNew.hide(); } 
});
select.trigger("init");
JS
);
