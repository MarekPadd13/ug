<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DictSupervisor */

$this->title = 'Create Dict Supervisor';
$this->params['breadcrumbs'][] = ['label' => 'Dict Supervisors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-supervisor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
