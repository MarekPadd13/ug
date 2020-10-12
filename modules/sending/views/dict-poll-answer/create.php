<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\sending\models\DictPollAnswers */

$this->title = 'Создать новый ответ';
$this->params['breadcrumbs'][] = ['label' => 'Ответы опросов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-poll-answers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
