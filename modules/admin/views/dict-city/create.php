<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DictCity */

$this->title = 'Создать запись';
$this->params['breadcrumbs'][] = ['label' => 'Города РФ и мира', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-city-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
