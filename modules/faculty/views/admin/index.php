<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Profiles;
use app\models\DictFaculty;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserFacultySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Назначение институтов/факультетов';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'last_name',
            'first_name',
            'patronymic',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>
</div>
