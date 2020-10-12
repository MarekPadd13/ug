<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DictCompetitiveGroup */

$this->title = $model->last_name. ' '. $model->first_name. ' '. $model->patronymic;
$this->params['breadcrumbs'][] = ['label' => 'Абитуриенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'last_name',
            'first_name',
            'patronymic',
            'phone',
        ],
    ]) ?>

</div>
