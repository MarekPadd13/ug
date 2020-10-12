<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DisciplineCompetitiveGroup */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Дисциплины и конкурснные группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
