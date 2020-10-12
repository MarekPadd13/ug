<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefProblems */

$this->title = 'Create Ref Problems';
$this->params['breadcrumbs'][] = ['label' => 'Ref Problems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-problems-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
