<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DictFacultySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Справочник институтов и факультетов МПГУ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить институт/факультет', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'full_name:ntext',

            Yii::$app->user->can('rbac') ?

                ['class' => 'yii\grid\ActionColumn',

                    'template' => '{update} {delete}',
                    'header' => 'Действия',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']), ['update', 'id' => $model->id]);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash']), ['delete', 'id' => $model->id]);
                        },
                    ],
                ] : ['class' => 'yii\grid\ActionColumn',

                'template' => '{update}',
                'header' => 'Действия',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']), ['update', 'id' => $model->id]);
                    },
                ],
            ],],
    ]); ?>
</div>
