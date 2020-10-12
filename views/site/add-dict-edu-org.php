<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

?>

<?php
$this->title = 'Добавление учебной организации';
$this->params['breadcrumbs'][] = $this->title;
?>



<?php $form = ActiveForm::begin(['id' => 'add-dict-edu-org', 'enableAjaxValidation' => true]); ?>

<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'country_id')->widget(Select2::className(), [
    'data' => $country,
    'options' => [
        'placeholder' => 'Выберите страну',
    ],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]) ?>

<?= $form->field($model, 'region_id')->widget(Select2::className(), [
    'data' => $region,
    'options' => [
        'placeholder' => 'Выберите регион',
    ],
    'pluginOptions' => [
        'allowClear' => true,
    ],
]) ?>
</div>

<div class="modal-footer">


    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>

</div>

<?php ActiveForm::end(); ?>

<?php $this->registerJs(<<<JS
var regionField = $("div.field-dictschoolspremoderation-region_id");
$("#dictschoolspremoderation-country_id").on("change init", function() {
    if (this.value == 46) { //@todo сделать константой
        regionField.show();
    } else {
        regionField.hide();

    }
}).trigger("init");
JS
);
?>



