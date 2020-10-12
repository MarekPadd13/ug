<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$form = ActiveForm::begin(['id' => 'add-ball']);
echo $form->field($model, 'ref_ball')->dropDownList([1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10])->label('Оцените по 10-балльной шкале на сколько важно решение данной проблемы:');
echo $form->field($model, 'ref_problems_id')->hiddenInput(['value'=> $no_voiting_problems->id])->label(false);?>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <?= Html::submitButton('Проголосовать', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>