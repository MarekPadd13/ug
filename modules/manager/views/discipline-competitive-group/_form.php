<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\DictDiscipline;
use app\models\DictCompetitiveGroup;
use yii\helpers\ArrayHelper;
use app\models\DictSpeciality;
use app\models\DictSpecialization;
use kartik\select2\Select2;

$specialityId = ArrayHelper::map(DictSpeciality::find()->all(), 'id', 'name');
$specializationId = ArrayHelper::map(DictSpecialization::find()->all(), 'id', 'name');
$form_edu = ['1'=> 'Очная', '2'=> 'Очно-заочная', '3'=> 'Заочная'];
$edu_level = ['1'=> 'БАК', '2'=> 'МАГ', '3'=> 'АСП'];

$disciplineId = ArrayHelper::map(DictDiscipline::find()->all(), 'id', 'name');

$cgid  = ArrayHelper::map(DictCompetitiveGroup::find()->all(), 'id', function($model) use($specialityId, $specializationId, $form_edu, $edu_level){
    return
        $edu_level[$model->edu_level]
        ." / ".$specialityId[$model->speciality_id]
        . " / ".$specializationId[$model->specialization_id]
        . " / ".$form_edu[$model->education_form_id];})

/* @var $this yii\web\View */
/* @var $model app\models\DisciplineCompetitiveGroup */
/* @var $form yii\widgets\ActiveForm */



?>

<div class="container">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'discipline_id')->widget(Select2::className(), [
        'data' => $disciplineId ,
        'options' => ['plaсeholder' => 'Выберите дисциплину'],
        'pluginOptions' => [
            'allowClear' => true,
        ]]) ?>

    <?= $form->field($model, 'competitive_group_id')->widget(Select2::className(), [
            'data' => $cgid,
        'options' => ['plaсeholder' => 'Выберите конкурсную группу'],
        'pluginOptions' => [
            'allowClear' => true,
    ]]) ?>

    <?= $form->field($model, 'priority')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
