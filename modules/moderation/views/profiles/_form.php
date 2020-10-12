<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Profiles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profiles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vk_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_id')->textInput() ?>

    <?= $form->field($model, 'house_id')->textInput() ?>

    <?= $form->field($model, 'number_of_apart')->textInput() ?>

    <?= $form->field($model, 'date_credit')->textInput() ?>

    <?= $form->field($model, 'activizm_id')->textInput() ?>

    <?= $form->field($model, 'what_will_you_do')->textInput() ?>

    <?= $form->field($model, 'what_do_with_bank')->textInput() ?>

    <?= $form->field($model, 'recognition_of_insurance')->textInput() ?>

    <?= $form->field($model, 'ddu_type')->textInput() ?>

    <?= $form->field($model, 'acreditive')->textInput() ?>

    <?= $form->field($model, 'mother_capital')->textInput() ?>

    <?= $form->field($model, 'miting')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
