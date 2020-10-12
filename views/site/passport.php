<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\DictCountry;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

$this->title = 'Заполнение паспортных данных';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(['id' => 'passport-form']); ?>
<?= $form->field($model, 'type_id')->dropDownList($model->GetTypeDoc()) ?>
<?= $form->field($model, 'citizenship')->widget(Select2::className(), [
    'data' => ArrayHelper::map(DictCountry::find()->all(), 'id', 'name'),
    'language' => 'ru',
    'options' => ['placeholder' => 'Выберите страну'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>
<?= $form->field($model, 'serial') ?>
<?= $form->field($model, 'number') ?>
<?= $form->field($model, 'issue') ?>
<?= $form->field($model, 'date_of_issue')->widget(DatePicker::class, [
    'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'clientOptions' =>[
        'yearRange' =>'1918:2011',
        'changeMonth' => true,
        'changeYear' => true,
        ],
]) ?>


<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
</div>
<?php ActiveForm::end(); ?>
