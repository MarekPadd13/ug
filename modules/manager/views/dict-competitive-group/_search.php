<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DictCompetitiveGroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dict-competitive-group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'speciality_id') ?>

    <?= $form->field($model, 'specialization_id') ?>

    <?= $form->field($model, 'edu_level') ?>

    <?= $form->field($model, 'education_form_id') ?>

    <?php // echo $form->field($model, 'financing_type_id') ?>

    <?php // echo $form->field($model, 'faculty_id') ?>

    <?php // echo $form->field($model, 'kcp') ?>

    <?php // echo $form->field($model, 'special_right_id') ?>

    <?php // echo $form->field($model, 'competition_count') ?>

    <?php // echo $form->field($model, 'passing score') ?>

    <?php // echo $form->field($model, 'link') ?>

    <?php // echo $form->field($model, 'is_new_program') ?>

    <?php // echo $form->field($model, 'only_pay_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
