<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\DictFaculty;
use kartik\datetime\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

?>

<div class="container">

    <?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]); ?>

    <?= $form->field($model, 'name')->textarea(['rows' => 3]) ?>


    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
    ]); ?>


    <?= $form->field($model, 'type')->checkbox() ?>


    <?php echo $form->field($model, 'date_time')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Введите дату и время ...'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy.mm.dd hh:ii'
        ]
    ]);
    ?>

    <?= $form->field($model, 'faculty_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(DictFaculty::find()->all(), 'id', 'full_name'),
        'language' => 'ru',
        'options' => ['placeholder' => 'Выберите институт/факультет'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    <?= $form->field($model, 'edu_level')->dropDownList(['0' => 'СПО', '1' => 'Бакалавриат', '2' => 'Магистратура', '3' => 'Аспирантура']) ?>

    <?= $form->field($model, 'aud_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 2]) ?>

    <?= $form->field($model, 'photo_report')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
