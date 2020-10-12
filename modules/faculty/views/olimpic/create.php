<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Olimpic */

$this->title = 'Создание олимпиады/конкурса';
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады/Конкурсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
