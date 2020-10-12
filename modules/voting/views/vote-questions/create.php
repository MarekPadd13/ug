<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VoteQuestions */

$this->title = 'Create Vote Questions';
$this->params['breadcrumbs'][] = ['label' => 'Vote Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vote-questions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
