<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VoteQuestions */

$this->title = 'Update Vote Questions: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Vote Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vote-questions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
