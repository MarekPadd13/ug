<?php

use app\modules\test\models\TestQuestion;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\sortable\Sortable;

/** @var $this yii\web\View */
/** @var $resultModel \app\modules\test\models\TestResult */
/** @var $question int|string */

$this->title = 'Вопрос №' . (int)$question;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">

    <h2><?= $resultModel->question->text ?></h2>

    Оставшееся время: <label id="timer"></label>

<?php $form = ActiveForm::begin(); ?>

<?php switch ($resultModel->question->type_id): ?>
<?php case TestQuestion::TYPE_SELECT: ?>
        <label>Выберите вариант(ы):</label>
        <?php foreach ($resultModel->question->optionsArray['text'] as $index => $text): ?>
            <?php if ($text === '') continue; ?>
            <p>
                <input type="text" value="<?= $text ?>" disabled="disabled"/>
                <input type="checkbox" value="<?= $index ?>" name="TestResult[resultArray][]"
                    <?= \in_array($index, $resultModel->resultArray) ? ' checked' : '' ?>/>
            </p>
        <?php endforeach; ?>
        <?php break; ?>
    <?php case TestQuestion::TYPE_SELECT_ONE: ?>
        <label>Выберите вариант:</label>
        <?php foreach ($resultModel->question->optionsArray['text'] as $index => $text): ?>
            <?php if ($text === '') continue; ?>
            <p>
                <input type="text" value="<?= $text ?>" disabled="disabled"/>
                <input type="radio" value="<?= $index ?>" name="TestResult[resultArray][]"
                    <?= \in_array($index, $resultModel->resultArray) ? ' checked' : '' ?>/>
            </p>
        <?php endforeach; ?>
        <?php break; ?>
    <?php case TestQuestion::TYPE_MATCHING: ?>
        <label>Сопоставьте</label>
        <table>
            <tr>
                <td>
                    <ul class="list-unstyled">
                        <?php $variantsCount = 0; ?>
                        <?php foreach ($resultModel->question->optionsArray['text'] as $index => $text): ?>
                            <?php if ($text === '') continue; ?>
                            <li>
                                <input type="text" value="<?= $text ?>" disabled="disabled"/>
                            </li>
                            <?php ++$variantsCount; ?>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <?php
                    if (\count($resultModel->resultArray) === 0) {
                        $resultArray = \range(0, $variantsCount - 1);
                        \shuffle($resultArray);
                    } else {
                        $resultArray = $resultModel->resultArray;
                    }
                    ?>
                    <?php $optionArray = []; ?>
                    <?php foreach ($resultArray as $index): ?>
                        <?php $optionArray[]['content'] = '<input type="text" disabled="disabled"' .
                            ' value="' . ($resultModel->question->optionsArray['option'][$index] ?? '') . '"/>' .
                            '<input type="hidden" name="TestResult[resultArray][]" value="' .
                            ($resultModel->question->optionsArray['option'][$index] ?? '') . '"/>';
                        ?>
                    <?php endforeach; ?>
                    <?= Sortable::widget([
                        'showHandle' => true,
                        'items' => $optionArray,
                    ]); ?>
                </td>
            </tr>
        </table>
        <?php break; ?>
    <?php case TestQuestion::TYPE_ANSWER_SHORT: ?>
        <label>Введите краткий ответ:</label>
        <input type="text" name="TestResult[resultArray][]" value="<?= $resultModel->resultArray[0] ?? '' ?>"/>
        <?php break; ?>
    <?php case TestQuestion::TYPE_ANSWER_DETAILED: ?>
        <label>Введите развёрнутый ответ:</label>
        <textarea name="TestResult[resultArray][]"><?= $resultModel->resultArray[0] ?? '' ?></textarea>
        <?php break; ?>
    <?php case TestQuestion::TYPE_FILE: ?>
        <label>Прикрепите файл с ответом:</label>
        <?= $form->field($resultModel, 'resultFile')->fileInput() ?>
        <?php $file = $resultModel->getResultFileName();
        if ($file): ?>
            Файл: <?= Html::a('Скачать', [Yii::getAlias($resultModel::ANSWER_FILES_PATH_WEB) .
                '/' . \basename($file)], ['target' => '_blank']) ?>
        <?php endif; ?>
        <?php break; ?>
    <?php endswitch; ?>

<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end(); ?>
    <br/>

<?php if ($question != 1): ?>
    <?= Html::a('Назад', ['process', 'testId' => $resultModel->attempt->test_id, 'question' => $question - 1]) ?>
<?php endif; ?>

<?php if ($question < $resultModel->attempt->getQuestionsCount()): ?>
    <?= Html::a('Вперёд', ['process', 'testId' => $resultModel->attempt->test_id, 'question' => $question + 1]) ?>
<?php else: ?>
    <?= Html::a('Завершить тест', ['end', 'testId' => $resultModel->attempt->test_id]) ?>
<?php endif; ?>

</div>

<?php
$startTime = $resultModel->attempt->start;
$testDuration = $resultModel->attempt->test->olimpic->time_of_distants_tour;
$this->registerJs(<<<JS
"use strict";
function timer(_time, _call) {
    timer.lastCall = _call;
    timer.lastTime = _time;
    timer.timerInterval = setInterval(function () {
        _call(_time[0], _time[1], _time[2]);
        _time[2]--;
        if (_time[0] == 0 && _time[1] == 0 && _time[2] == 0) {
            timer.pause();
            _call(0, 0, 0);
        }
        if (_time[2] == 0) {
            _time[2] = 59;
            _time[1]--;
            if (_time[1] == 0) {
                _time[1] = 59;
                _time[0]--;
            }
        }
        timer.lastTime = _time;
    }, 1000);
}

var time = {$testDuration} * 60 - (Date.now() - Date.parse("{$startTime}")) / 1000;
var h = 0, m = 0, s = 0;
if (time > 0) {
    h = Math.trunc(time / 60 / 60);
    m = Math.trunc((time - (h * 60 * 60)) / 60);
    s = Math.trunc(time - h * 60 * 60 - m * 60);
}

var labelTimer = $("#timer");
timer([h, m, s], function(h, m, s) {
    if (h == 0 && m == 0 && s == 0) {
        location.reload();
    }

    labelTimer.text(h + ":" + m + ":" + s);
});
JS
);

