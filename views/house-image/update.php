<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Stream */

$this->title = 'Редактирование настрек камеры: ' . $model->cameraName;
$this->params['breadcrumbs'][] = ['label' => 'Все камеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="stream-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
