<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use himiklab\yii2\ajaxedgrid\GridView;
use yii\data\ActiveDataProvider;

$this->title = 'Добавить поездку';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1 align="center"><?= $this->title ?></h1>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]); ?>

            <?= $form->field($model, 'type_id')->dropDownList($model->typeTrip()) ?>

            <?= $form->field($model, 'places')->textInput(['type' => 'number', 'min' => '1']) ?>

            <?= $form->field($model, 'date')->widget(DatePicker::className(), [
//    'inline' => true,
                'dateFormat' => "yyyy-MM-dd",
                'clientOptions' => [
                    'minDate' => '0',
                ],
            ]) ?>

            <?php
            if (!$model->isNewRecord) {

                GridView::widget([
                    'dataProvider' => new ActiveDataProvider(['query' => $model->getCarpoolingMetros()]),
                    'addButtons' => ['Добавить станции метро'],
                    'createRoute' => 'site/add-metro?id=' . $model->id,
                    'deleteRoute' => 'delete-trip-metro',
                    'modalConfig' => ['size' => 'Modal::SIZE_SMALL'],
                    'actionColumnTemplate' => '{delete}',
                    'columns' => [
                        'metro.name',
                        'time',
                    ],
                ]);
            }
            ?>



            <?= $form->field($model, 'note')->textarea(['row' => 6]) ?>

            <?= Html::submitButton($nameButton, ['class' => 'btn btn-primary']) ?>

            <?php ActiveForm::end() ?>
        </div>
    </div>

</div>
