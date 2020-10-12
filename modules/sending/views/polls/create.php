<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\sending\models\Polls */

$this->title = 'Создание опроса';
$this->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="polls-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
