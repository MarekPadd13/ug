<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MasterClass */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Все мастер-классы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
