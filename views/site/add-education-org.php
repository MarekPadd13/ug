<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->title = 'Добавление данных об учебной организации';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="answer-details" class="container">
    <h1><?= $this->title ?></h1>
    <?php $form = ActiveForm::begin(['id' => 'add-education-org']); ?>


    <?php if (!$existReg) : ?>
        <?php echo Html::a(
            'В списке нет Вашей образовательной организации?',
            '#addEduDictOrg',
            [
                'data-pjax' => '0',
                'data-toggle' => 'modal',
                'data-modal' => '#addEduDictOrg',
                'data-remote' => Url::toRoute(['/site/add-dict-edu-org']),
            ]
        ); ?>
    <?php endif ?>

    <?= $form->field($model, 'school_id')->widget(Select2::className(), [
        'data' => $school,
        'options' => ['placeholder' => 'Выберите учебную организацию из списка'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>





    <?= $form->field($model, 'class_id')->widget(Select2::className(), [
        'data' => $classes,
        'options' => ['placeholder' => 'Выберите текущий класс/курс'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>

    <?php if (!$existReg): ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>
    <?php endif; ?>
    <?php ActiveForm::end(); ?>

    <?php Modal::begin(['id' => 'addEduDictOrg', 'header' => '<h4 class="modal-title">Добавить образовательную организацию</h4>', 'size' => Modal::SIZE_LARGE]) ?>
    <?php
    echo "<div id='modalContent1'>";
    echo "</div>";
    Modal::end() ?>

</div>

<?php
if ($existReg) {
    Yii::$app->session->setFlash('error', 'Вы не можете редактировать данные Вашей учебной организации, так как записаны на одну из олимпиад. 
    Для редактирования отмените все записи и снова перейдите на эту страницу.');
    $this->registerJs(<<<JS
    $("#userschool-school_id").attr("disabled", true);
    $("#userschool-class_id").attr("disabled", true);

JS
    );
}
?>

<?php
$this->registerJs(<<<JS
$("#answer-details").on("click", "a[data-toggle='modal']", function() {
    var button = $(this);
    $("div" + button.data("modal") + " div.modal-body").load(button.data("remote"));
});
JS
);
?>



