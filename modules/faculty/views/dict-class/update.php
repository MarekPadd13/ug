<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DictClass */

$this->title = 'Обновление: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Классы/курсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
