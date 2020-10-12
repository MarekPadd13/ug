<?php

use yii\helpers\Html;

/** @var $attemptModel \app\modules\test\models\TestAttempt */

$this->title = 'Начало тестирования';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    Продолжительность тестирования: <?= $attemptModel->test->olimpic->time_of_distants_tour ?> мин.<br/>

    <div>
        <?= $attemptModel->test->introduction ?>
    </div>

    <?= Html::a('Начать тестирование', ['process', 'testId' => $attemptModel->test_id]) ?>
</div>