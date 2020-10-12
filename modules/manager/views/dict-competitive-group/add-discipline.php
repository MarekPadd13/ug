<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\DictDiscipline;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\DictCompetitiveGroup */
/* @var $form yii\widgets\ActiveForm */

$discipline = ArrayHelper::map(DictDiscipline::find()->all(), 'id', 'name');
?>

<div class="container">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, 'discipline_id')->widget(Select2::className(), [
        'data' => $discipline,
        'options' => ['placeholder' => 'Выберите дисциплину'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>


    <?=$form->field($model, 'priority')->DropDownList($model->competitiveGroup->getPriority()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
