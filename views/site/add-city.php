<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\DictCountry;
use app\models\DictRegion;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\DictCity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dict-city-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country')->widget(Select2::className(), [
        'data' => ArrayHelper::map(DictCountry::find()->all(), 'id', 'name'),
        'language' => 'ru',
        'options' => ['placeholder' => 'Выберите страну'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'region')->widget(Select2::className(), [
        'data' => ArrayHelper::map(DictRegion::find()->all(), 'id', 'name'),
        'language' => 'ru',
        'options' => ['placeholder' => 'Выберите регион'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
