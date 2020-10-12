<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Olimpic */

$this->title = 'Обновление: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады/Конкурсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
