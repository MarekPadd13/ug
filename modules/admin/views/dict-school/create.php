<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DictSchool */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Создать', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-school-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
