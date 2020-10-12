<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\DictFaculty;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MastersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ведущие мастер-классов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php $faculty = ArrayHelper::map(DictFaculty::find()->all(), 'id', 'full_name') ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name:ntext',
            'status:ntext',
            [
                'attribute' => 'faculty_id',
                'value' => function ($model) use ($faculty) {
                    return $faculty[$model->faculty_id];
                },
                'filter' => $faculty,
                'enableSorting' => false,
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>
</div>
