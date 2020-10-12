<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use app\models\RefKomments;

/* @var $this yii\web\View */
/* @var $model app\models\DictCity */
/* @var $form yii\widgets\ActiveForm */

$all_komments = ArrayHelper::map(RefKomments::find()->andWhere(['moderation'=>true])->all(), 'id', 'text') + ['0' => 'Указать свой вариант'];

?>
<?php $form = ActiveForm::begin(); ?>

<?=$form->field($model, 'komment')->DropdownList($all_komments)?>
<?=$form->field($model, 'komment_text')->textarea(['row'=>'2', 'id'=> 'hidden_fields', 'placeholder'=> 'Укажите здесь свой вариант не более 56 символов'])->label(false);?>


<div class="form-group">
        <?=Html::submitButton('Проголосовать против', ['class' => 'btn btn-danger']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php $this->registerJs(<<<JS
$("select").change(function() {
  if ($(this).find("option:selected").attr('value') == 0) {
    $('#hidden_fields').show();
    $('#hidden_fields').attr('required', 'required');
  }else{
      $('#hidden_fields').hide();
      $('#hidden_fields').removeAttr('required');
  }
});
JS
    );
?>





