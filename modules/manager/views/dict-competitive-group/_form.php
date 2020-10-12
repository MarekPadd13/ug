<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\DictSpeciality;
use app\models\DictFaculty;
use app\models\DictSpecialization;
use yii\data\ActiveDataProvider;
use himiklab\yii2\ajaxedgrid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\DictCompetitiveGroup */
/* @var $form yii\widgets\ActiveForm */

$specialityId = ArrayHelper::map(DictSpeciality::find()->all(), 'id', function ($model) {
    return $model->code . ' - ' . $model->name;
});
$specializationId = ArrayHelper::map(DictSpecialization::find()->all(), 'id', 'name');
$faculty = ArrayHelper::map(DictFaculty::find()->all(), 'id', 'full_name');

?>

<div class="container">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'speciality_id')->widget(Select2::className(), [
        'data' => $specialityId,
        'options' => ['placeholder' => 'Выберите направление подготовки'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>


    <?= $form->field($model, 'specialization_id')->widget(Select2::className(), [
        'data' => $specializationId,
        'options' => ['placeholder' => 'Выберите образовательную программу'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'edu_level')->DropDownList($model->getEduLevels()) ?>

    <?= $form->field($model, 'education_form_id')->DropDownList($model->getEduForms()) ?>

    <?= $form->field($model, 'financing_type_id')->DropDownList($model->getFinancingTypes()) ?>

    <?= $form->field($model, 'faculty_id')->widget(Select2::className(), [
        'data' => $faculty,
        'options' => ['placeholder' => 'Выберите институт/факультет'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'kcp')->textInput() ?>

    <?= $form->field($model, 'special_right_id')->DropDownList($model->getSpecialRight()) ?>

    <?= $form->field($model, 'competition_count')->textInput() ?>

    <?= $form->field($model, 'passing_score')->textInput() ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_new_program')->checkbox() ?>

    <?= $form->field($model, 'only_pay_status')->checkbox() ?>

    <?= $form->field($model, 'education_duration')->textInput() ?>

    <?php if ($model->save()): ?>

        <?php
        if ($model->isNewRecord) {

            echo 'Сначала сохраните основные данные<br/>';

        } else {


            GridView::widget(
                [
                    'dataProvider' => new ActiveDataProvider (['query' => $model->getDisciplinesCg()]),
                    'columns' => [
                        'discipline.name',
                        'priority',
                    ],
                    'createRoute' => ['dict-competitive-group/add-discipline',
                        'id' => $model->id],
                    'updateRoute' => ['dict-competitive-group/update-discipline'],
                    'deleteRoute'=> ['dict-competitive-group/delete-ds-cg'],
                ]


            );
        }

        ?>
    <?php endif ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
