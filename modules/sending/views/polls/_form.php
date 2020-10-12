<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use himiklab\yii2\ajaxedgrid\GridView;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model app\modules\sending\models\Polls */
/* @var $form yii\widgets\ActiveForm */

$query = \app\modules\sending\models\PollPollAnswer::find()->andWhere(['poll_id' => $model->id]);

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => false,
]);

$pollAnswerName = \app\modules\sending\models\DictPollAnswers::find()
    ->select('name')
    ->indexBy('id')
    ->column();
?>

<div class="polls-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',['filter'=>'flash']),
    ]);?>
    <?php
    if (!$model->isNewRecord) {
        GridView::widget([
            'dataProvider' => $dataProvider,
            'addButtons' => ['Добавить вариант ответа'],
            'createRoute' => ['add-item', 'pollId'=>$model->id],
            'updateRoute'=> 'update-item',
            'deleteRoute'=> 'delete-item',
            'columns' => [
                [
                    'attribute' => 'poll_answer_id',
                    'value' => function ($model) use ($pollAnswerName) {
                        return $pollAnswerName[$model->poll_answer_id];
                    }
                ]
            ],
        ]);
    }
    ?>


    <div class="form-group">
        <?= $model->isNewRecord ? Html::submitButton('Создать', ['class' => 'btn btn-success'])
            : Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
