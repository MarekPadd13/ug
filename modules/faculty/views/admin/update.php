<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserFaculty */

$this->title = 'Обновить: ';
$this->params['breadcrumbs'][] = ['label' => 'Назначения', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>