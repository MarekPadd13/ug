<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use yii\widgets\MaskedInput;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;


$this->title = 'Указать на проблему';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin(['id' => 'add-problems-form', 'enableAjaxValidation' => true]); ?>

<?= $form->field($model, 'name')->textInput() ?>

<?= $form->field($model, 'description')->textArea(['row'=> 6]) ?>

<?= $form->field($model, 'full_text')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder',['filter'=>'flash']),
]);?>



<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
