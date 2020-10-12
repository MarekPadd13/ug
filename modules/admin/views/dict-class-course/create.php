<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DictClassCourse */

$this->title = 'Create Dict Class Course';
$this->params['breadcrumbs'][] = ['label' => 'Dict Class Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-class-course-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
