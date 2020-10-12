<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DictCompetitiveGroup */

$this->title = 'Обновить';
$this->params['breadcrumbs'][] = ['label' => 'Конкурсные группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
