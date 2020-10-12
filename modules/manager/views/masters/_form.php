<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\DictFaculty;

/* @var $this yii\web\View */
/* @var $model app\models\Masters */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'status')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'faculty_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(DictFaculty::find()->all(), 'id', 'full_name'),
        'language' => 'ru',
        'options' => ['placeholder' => 'Выберите институт/факультет'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
