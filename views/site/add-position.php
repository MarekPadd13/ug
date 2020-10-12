<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;


$this->title = 'Предложить должность';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin(['id' => 'add-position-form', 'enableAjaxValidation' => true]); ?>
<div class="modal-body">

<?= $form->field($model, 'name')->textInput() ?>
<?= $form->field($model, 'description')->textarea(['row'=>12])?>

<?= $form->field($model, 'ball')->textInput() ?>


</div>

<div class="modal-footer">
    <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
