<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DictSupervisor */

$this->title = 'Update Dict Supervisor: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dict Supervisors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dict-supervisor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
