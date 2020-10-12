<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Olimpic;
use kartik\select2\Select2;
use app\models\Templates;

/* @var $this yii\web\View */
/* @var $model app\models\OlimpiadsTypeTemplates */
/* @var $form yii\widgets\ActiveForm */

$templates = Templates::find()->select('name')->indexBy('id')->column();
?>

<div class="container">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'number_of_tours')->dropDownList(Olimpic::numberOfTours()) ?>

    <?= $form->field($model, 'form_of_passage')->dropDownList(Olimpic::formOfPassage()) ?>

    <?= $form->field($model, 'edu_level_olimp')->dropDownList(Olimpic::levelOlimp()) ?>

    <?= $form->field($model, 'template_id')->widget(Select2::className(), [
        'data' => $templates,
        'options' => ['placeholder' => 'Выберите шалон'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <div class="form-group">
        <?php if ($model->isNewRecord) : ?>
            <?= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
        <?php else : ?>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?php endif ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>
