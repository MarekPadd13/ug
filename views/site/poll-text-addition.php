<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model
 */

?>

<?php $form = ActiveForm::begin(['id'=>'poll-text-addition']) ?>

<?=$form->field($model, 'textAddition')->textarea(['row'=>6]);?>

<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end()?>
