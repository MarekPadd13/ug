<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\OlimpiadsTypeTemplates */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Соответствие шаблонов с типами олимпиад', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
