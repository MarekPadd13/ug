<?php

use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \app\modules\admin\form\FileBueJsonForm */

$this->title = 'Загрузить чек';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create">
    <h1><?= Html::encode($this->title) ?></h1>
        <?php $form = ActiveForm::begin([
            'options' => [
                'enctype' => 'multipart/form-data',
            ]]); ?>

        <?= $form->field($model, 'file')->widget(FileInput::class)?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
</div>

