<?php

/** @var $attemptModel \app\modules\test\models\TestAttempt */

$this->title = 'Конец тестирования';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">

    <div>
        <?= $attemptModel->test->final_review ?>
    </div>

    <?php if (($resultMark = $attemptModel->evulate()) !== null): ?>
        Ваш результат: <?= $resultMark ?> баллов.
    <?php else: ?>
        Результаты выставляются в срок не позднее 5 рабочих дней со дня завершения заочного тура.
        Вы их сможете увидеть в личном кабинете или на странице олимпиады.
    <?php endif; ?>
</div>