<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProfilesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profiles-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'last_name') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'patronymic') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'vk_id') ?>

    <?php // echo $form->field($model, 'bank_id') ?>

    <?php // echo $form->field($model, 'house_id') ?>

    <?php // echo $form->field($model, 'number_of_apart') ?>

    <?php // echo $form->field($model, 'number_duu') ?>

    <?php // echo $form->field($model, 'date_ddu') ?>

    <?php // echo $form->field($model, 'number_credit') ?>

    <?php // echo $form->field($model, 'date_credit') ?>

    <?php // echo $form->field($model, 'activizm_id') ?>

    <?php // echo $form->field($model, 'what_will_you_do') ?>

    <?php // echo $form->field($model, 'what_do_with_bank') ?>

    <?php // echo $form->field($model, 'recognition_of_insurance') ?>

    <?php // echo $form->field($model, 'ddu_type') ?>

    <?php // echo $form->field($model, 'acreditive') ?>

    <?php // echo $form->field($model, 'mother_capital') ?>

    <?php // echo $form->field($model, 'miting') ?>

    <?php // echo $form->field($model, 'confirm') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
