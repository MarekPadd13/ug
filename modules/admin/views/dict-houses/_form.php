<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DictAngle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dict-houses-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'flat_count')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'deadline')->widget(DatePicker::class, [
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]]); ?>
    <?= $form->field($model, 'moderation')->dropDownList(\app\models\DictHouses::moderationItem()); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
