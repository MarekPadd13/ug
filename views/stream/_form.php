<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Stream */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stream-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cameraName')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'bodyStream')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'jk_id')->dropDownList(\app\models\Stream::ALL_JK); ?>


    <div class="form-group" >
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
