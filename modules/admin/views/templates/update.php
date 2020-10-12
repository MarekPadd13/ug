<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Templates */

$this->title = 'Редактирование шаблона: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
