<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DictCity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dict-city-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'question')->textarea(['rows'=> 10]); ?>



    <div class="form-group">
        <?= Html::submitButton('Задать вопрос', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
