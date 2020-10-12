<?php

use yii\helpers\Html;


/* @var $this yii\web\View */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Слайдеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
