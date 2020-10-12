<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\sending\models\DictPollAnswers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dict-poll-answers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?=$form->field($model, 'text_addition')->checkbox()?>

    <div class="form-group">
        <?= $model->isNewRecord ? Html::submitButton('Создать', ['class' => 'btn btn-success']) : Html::submitButton('Обновить', ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
