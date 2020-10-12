<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DictAngle */

$this->title = 'Создать ракурс';
$this->params['breadcrumbs'][] = ['label' => 'Ракурсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-angle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
