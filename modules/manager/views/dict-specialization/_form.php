<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\DictSpeciality;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\DictSpecialization */
/* @var $form yii\widgets\ActiveForm */

$specialityId = ArrayHelper::map(DictSpeciality::find()->all(), 'id', function ($model) {
    return $model->code . ' - ' . $model->name;
});
?>

<div class="container">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'speciality_id')->widget(Select2::className(), [
        'data' => $specialityId,
        'options' => ['plaсeholder' => 'Выберите направление подготовки'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
