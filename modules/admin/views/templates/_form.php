<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use app\models\Templates;

/* @var $this yii\web\View */
/* @var $model app\models\Templates */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_for_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_id')->dropDownList(Templates::typeTemplates()) ?>

    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
    ]); ?>

    <div class="form-group">
        <?php if ($model->isNewRecord) : ?>
            <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
        <?php else : ?>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?php endif ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
