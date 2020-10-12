<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\DictCity;


/* @var $this yii\web\View */
/* @var $model app\models\DictSchool */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dict-school-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dict_city_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(DictCity::find()->all(),'id','name'),
            'language' => 'ru',
            'options' => ['placeholder' => 'Выберите город, где расположена организация'],
            'pluginOptions' =>[
                    'allowClear'=>true,
            ],

    ]) ?>
    <?= $form->field($model, 'moderation')->dropDownList($model->GetModerationItem()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
