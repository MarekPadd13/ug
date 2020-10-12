<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VoteQuestions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vote-questions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type')->dropDownList($model->type()) ?>

    <?= $form->field($model, 'extension')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php $this->registerJs(<<<JS
var regionField = $("div.field-votequestions-extension");
$("#votequestions-type").on("change init", function() {
    if (this.value == 2) { //@todo сделать константой
        regionField.show();
    } else {
        regionField.hide();
    }
}).trigger("init");
JS
    );
    ?>

</div>
