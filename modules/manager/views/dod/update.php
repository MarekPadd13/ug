<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dod */

$this->title = 'Обновить: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Все дни открытых дверей', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
