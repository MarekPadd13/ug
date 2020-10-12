<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\DictCity */
/* @var $form yii\widgets\ActiveForm */

?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'ball')->dropDownList([1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10])?>

<div class="form-group">
        <?= Html::submitButton('Проголосовать', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
