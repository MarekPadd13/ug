<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DictRegion */

$this->title = 'Create Dict Region';
$this->params['breadcrumbs'][] = ['label' => 'Dict Regions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-region-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
