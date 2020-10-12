<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\DictFaculty;
use app\models\Masters;
use app\models\Dod;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\MasterClass */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'master_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(Masters::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Выберите ведущего мастер-класса'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'aud_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time_start')->widget(DateTimePicker::className(), [
        'options' => ['placeholder' => 'Дата и время начала мастер-класса'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy.mm.dd hh:ii'
        ],
    ]) ?>

    <?= $form->field($model, 'time_finish')->widget(DateTimePicker::className(), [
        'options' => ['placeholder' => 'Дата и время окончания мастер-класса'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy.mm.dd hh:ii'
            ,
        ],
    ]) ?>

    <?= $form->field($model, 'dod_id')->widget(select2::className(), [
        'data' => ArrayHelper::map(Dod::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Выберите мероприятие'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
