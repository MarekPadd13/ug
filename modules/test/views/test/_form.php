<?php

/** @var $model \app\modules\test\models\Test */

/** @var $isReadOnly boolean */

use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;


?>


<?php $form = ActiveForm::begin(['id' => 'test-form']); ?>

<?= $form->errorSummary($model) ?>

<?= $form->field($model, 'introduction')->widget(CKEditor::class, [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
]); ?>


<?= $form->field($model, 'final_review')->widget(CKEditor::class, [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
]); ?>



<?= $form->field($model, 'classesList')->widget(Select2::class, [
    'data' => $model->allowedClasses(),
    'options' => ['placeholder' => 'Выберите классы', 'multiple' => true],
]) ?>

<?= $form->field($model, 'questionGroupsList')->widget(Select2::class, [
    'data' => $model->allowedGroups(),
    'options' => ['placeholder' => 'Выберите группы вопросов', 'multiple' => true],
]) ?>

    <div class="form-group">
        <?php if ($isReadOnly): ?>
            <?= Html::a(
                'Начать заполнение тестирования',
                ['/test/question', 'olimpicId' => $model->olimpic_id],
                ['class' => 'btn btn-success']
            ) ?>
        <?php else: ?>
            <?= Html::submitButton('Начать заполнение тестирования', ['class' => 'btn btn-success']) ?>
        <?php endif; ?>


<?php ActiveForm::end(); ?>
</div>
<?php
if ($isReadOnly) {
    $this->registerJs(<<<JS
$("input, select", $("#{$form->id}")).attr("disabled", true);
JS
    );
}
