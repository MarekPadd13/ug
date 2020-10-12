<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\sending\models\Polls */

$this->title = 'Обновление: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => ['index']];
?>
<div class="polls-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>



</div>
