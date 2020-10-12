<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'h1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['row' => 3, 'maxlength' => true]) ?>


    <?= $form->field($model, 'page')->widget(CKEditor::className(), [
        'editorOptions' =>
            [ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash', 'preset' => 'full']),
                'allowedContent' => true,
                ],
    ]); ?>

    <?= $form->field($model, 'status')->checkBox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
