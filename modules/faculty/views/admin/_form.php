<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Profiles;
use app\models\DictFaculty;

/* @var $this yii\web\View */
/* @var $model app\models\UserFaculty */
/* @var $form yii\widgets\ActiveForm */

$fullNameUser = ArrayHelper::map(Profiles::find()->all(), 'user_id', function ($model) {
    return $model->last_name . ' ' . $model->first_name . ' ' . $model->patronymic.' ('.$model->user->username.')';
});
$faculty = ArrayHelper::map(DictFaculty::find()->all(), 'id', 'full_name');

?>

<div class="container">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->widget(Select2::className(), [
        'data' => $fullNameUser,
        'options' => ['placeholder' => 'Выберите ФИО пользователя'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'faculty_id')->widget(Select2::className(), [
        'data' => $faculty,
        'options' => ['placeholder' => 'Выберите Институт/факультет'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
