<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use yii\widgets\MaskedInput;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;


$this->title = 'Предложить решение (шаг 1)';
$this->params['breadcrumbs'][] = ['label' => $problem->name, 'url' => ['/site/full-text', 'id' => $problem->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3>Шаг 1. Изложите суть решения проблемы: <?=$problem->name?></h3>

<?php $type = [1 => 'действие поразумевает только один цикл', 2 => 'действие поразумевает несколько циклов']?>

<?php $form = ActiveForm::begin(['id' => 'add-solution-form']); ?>

<?=$form->field($model, 'name')->textInput() ?>
<?=$form->field($model, 'type')->dropDownList($type)?>
<?=$form->field($model, 'description')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder',['filter'=>'flash']),
]);?>


<?=$form->field($model, 'content')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder',['filter'=>'flash']),
]);?>



<div class="form-group">
    <?=Html::submitButton('Далее', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
