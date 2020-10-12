<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RefProblems */

$this->title = 'Update Ref Problems: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ref Problems', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-problems-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
