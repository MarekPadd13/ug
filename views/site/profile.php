<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\DictCountry;
use app\models\DictRegion;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;


/* @var $this yii\web\View */
/* @var $model app\models\Profiles */

$this->title = 'Ваш профиль';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'last_name')->textInput([!$userRegOlimpic ? '\'maxlength\' => true' : 'readOnly' => 'readOnly', 'maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput([!$userRegOlimpic ? '\'maxlength\' => true' : 'readOnly' => 'readOnly', 'maxlength' => true]) ?>

    <?= $form->field($model, 'patronymic')->textInput([!$userRegOlimpic ? '\'maxlength\' => true' : 'readOnly' => 'readOnly', 'maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
        'mask' => '+7(999)999-99-99',]) ?>

    <?= $form->field($model, 'country_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(DictCountry::find()->all(), 'id', 'name'),
        'language' => 'ru',
        'options' => ['placeholder' => 'Выберите страну, в которой проживаете'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'region_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(DictRegion::find()->all(), 'id', 'name'),
        'language' => 'ru',
        'options' => ['placeholder' => 'Выберите регион'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php if (!$userRegOlimpic) : ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

    <?php endif; ?>

    <?php ActiveForm::end(); ?>


    <?php
    if ($userRegOlimpic) {
        $this->registerJs(<<<JS
$("#profiles-phone, #profiles-country_id, #profiles-region_id").attr("disabled", true);

JS
        );
    }

    ?>

    <?php $this->registerJs(<<<JS
var regionField = $("div.field-profiles-region_id");
$("#profiles-country_id").on("change init", function() {
    if (this.value == 46) { //@todo сделать константой
        regionField.show();
    } else {
        regionField.hide();
    }
}).trigger("init");
JS
    );
    ?>

</div>
