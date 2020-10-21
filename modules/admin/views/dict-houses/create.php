<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DictHouses */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Дома', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-angle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
