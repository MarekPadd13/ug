<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DictChairmans */

$this->title = 'Добавление председателя оргкоммитета';
$this->params['breadcrumbs'][] = ['label' => 'Председатели', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
