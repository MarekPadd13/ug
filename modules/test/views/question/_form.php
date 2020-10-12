<?php

/** @var $model \app\modules\test\models\TestQuestion */
/** @var $olimpicId int */
/** @var $this yii\web\View */

use app\modules\test\models\TestQuestionGroup;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\sortable\Sortable;

?>
<?php $form = ActiveForm::begin(['id' => 'question-form']); ?>

<?= $form->errorSummary($model) ?>

<?= $form->field($model, 'group_id')->widget(Select2::class, [
    'data' => TestQuestionGroup::find()
        ->andWhere(['olimpic_id' => $olimpicId])
        ->select('name')
        ->indexBy('id')
        ->column(),
    'pluginOptions' => ['tags' => true],
    'options' => ['placeholder' => 'Выберите или введите группу'],
]); ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'text')->widget(CKEditor::class, [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['filter' => 'flash']),
]); ?>

<?= $form->field($model, 'mark')->textInput() ?>

<?php switch ($model->type_id): ?>
<?php case $model::TYPE_SELECT: ?>
        <label>Варианты ответов</label>
        <?php for ($n = 0; $n <= 5; ++$n): ?>
            <p>
                <input type="text" name="TestQuestion[optionsArray][text][]"
                       value="<?= $model->optionsArray['text'][$n] ?? '' ?>"/>
                <input type="checkbox" value="<?= $n ?>" name="TestQuestion[optionsArray][isCorrect][]"
                    <?= isset($model->optionsArray['isCorrect']) &&
                    \in_array($n, $model->optionsArray['isCorrect']) ? ' checked' : '' ?>/>
            </p>
        <?php endfor; ?>
        <?php break; ?>

    <?php case $model::TYPE_SELECT_ONE: ?>
        <label>Варианты ответов</label>
        <?php for ($n = 0; $n <= 5; ++$n): ?>
            <p>
                <input type="text" name="TestQuestion[optionsArray][text][]"
                       value="<?= $model->optionsArray['text'][$n] ?? '' ?>"/>
                <input type="radio" value="<?= $n ?>" name="TestQuestion[optionsArray][isCorrect][]"
                    <?= isset($model->optionsArray['isCorrect']) &&
                    \in_array($n, $model->optionsArray['isCorrect']) ? ' checked' : '' ?>/>
            </p>
        <?php endfor; ?>
        <?php break; ?>

    <?php case $model::TYPE_MATCHING: ?>
        <label>Сопоставьте</label>
        <table>
            <tr>
                <td>
                    <ul class="list-unstyled">
                        <?php $optionArray = []; ?>
                        <?php for ($n = 0; $n <= 5; ++$n): ?>
                            <li>
                                <input type="text" name="TestQuestion[optionsArray][text][]"
                                       value="<?= $model->optionsArray['text'][$n] ?? '' ?>"/>
                            </li>
                            <?php $optionArray[]['content'] = '<input type="text" name="TestQuestion[optionsArray][option][]"' .
                                ' value="' . ($model->optionsArray['option'][$n] ?? '') . '"/>'; ?>
                        <?php endfor; ?>
                    </ul>
                </td>
                <td>
                    <?= Sortable::widget([
                        'showHandle' => true,
                        'items' => $optionArray,
                    ]); ?>
                </td>
            </tr>
        </table>
        <?php break; ?>

    <?php case $model::TYPE_ANSWER_SHORT: ?>
        <label>Варианты ответов</label>
        <?php for ($n = 0; $n <= 5; ++$n): ?>
            <p>
                <input type="text" name="TestQuestion[optionsArray][]" value="<?= $model->optionsArray[$n] ?? '' ?>"/>
            </p>
        <?php endfor; ?>
        <?php break; ?>

    <?php case $model::TYPE_FILE: ?>
        <?= $form->field($model, 'file_type_id')->dropDownList($model::getAllFileTypes()) ?>
        <?php break; ?>
    <?php endswitch; ?>

<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end(); ?>
