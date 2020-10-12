<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DictClass */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container">

    <?php $form = ActiveForm::begin(['options'=>['autocomplete'=> 'off']]); ?>

    <?= $form->field($model, 'name')->dropDownList($model::classes()) ?>

    <?= $form->field($model, 'type')->dropDownList($model::typeOfClass()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
