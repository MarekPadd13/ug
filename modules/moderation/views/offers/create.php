<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefAnswer */

$this->title = 'Create Ref Answer';
$this->params['breadcrumbs'][] = ['label' => 'Ref Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-answer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
