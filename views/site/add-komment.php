<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(['id' => 'add-komment']); ?>
 <?= $form->field($model, 'text')->textInput(['maxlength' => true]) ?>

     <div class="form-group">
        <?= Html::submitButton('Добавить комментарий', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end();