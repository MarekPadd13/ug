<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DictSchool */

$this->title = 'Обновить';
$this->params['breadcrumbs'][] = ['label' => 'Учебные организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="dict-school-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
