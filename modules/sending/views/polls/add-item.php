<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


?>

<?php $form = ActiveForm::begin(['id' => 'add-item']); ?>

<?= $form->field($model, 'poll_answer_id')->widget(Select2::className(), [
    'data' => \app\modules\sending\models\DictPollAnswers::getAllItems(),
    'options' => ['placeholder' => 'Выберите вариант ответа'],
    'pluginOptions' => [
        'allowClear' => true,
    ],

]);
?>

<div class="form-group">
    <?= $model->isNewRecord ? Html::submitButton('Добавить', ['class' => 'btn btn-success'])
        : Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

