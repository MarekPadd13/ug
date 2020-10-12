<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $homeImage app\models\HomeImage */

$this->title = 'Обновить ID ' . $homeImage->id;
$this->params['breadcrumbs'][] = ['label' => 'Фото домов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $homeImage->id, 'url' => ['view', 'id' => $homeImage->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-answer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
