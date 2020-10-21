<?php

use app\models\DictHouses;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EndHomeBuild */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="end-home-build-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'home_id')->widget(Select2::class, [
        'data' => DictHouses::allColumn(),
        'options' => ['placeholder' => 'Укажите номер дома'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'number')->textInput() ?>

    <?= $form->field($model, 'date')->widget(DatePicker::class, [
        'pluginOptions' => [
            'endDate' => '+0d',
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]]); ?>



    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
