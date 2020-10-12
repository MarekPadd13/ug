<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Links */

$this->title = 'Обновление: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ссылки', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="links-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
