<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DictFaculty */

$this->title = 'Обновить: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Все институты/факультеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>