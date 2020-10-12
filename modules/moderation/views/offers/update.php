<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RefAnswer */

$this->title = 'Update Ref Answer: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ref Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-answer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
