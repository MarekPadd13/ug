<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DisciplineCompetitiveGroup */

$this->title = 'Обновление: ' . $model->discipline_id;
$this->params['breadcrumbs'][] = ['label' => 'Discipline Competitive Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
