<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DictDiscipline */

$this->title = 'Добавить новую дисциплину';
$this->params['breadcrumbs'][] = ['label' => 'Дисциплины', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
