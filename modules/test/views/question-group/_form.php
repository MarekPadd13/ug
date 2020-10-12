<?php

/** @var $model \app\modules\test\models\Test */

use app\models\Olimpic;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

    <?php $form = ActiveForm::begin(['id' => 'question-group-form']); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->field($model, 'olimpic_id')->widget(Select2::class, [
        'data' => Olimpic::find()->select('name')->indexBy('id')->column(),
        'options' => ['placeholder' => 'Выберите олимпиаду',],
    ]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>