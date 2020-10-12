<?php

/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $this yii\web\View */

/** @var \app\models\Olimpic $olimpicModel */

use himiklab\yii2\ajaxedgrid\GridView;
use yii\helpers\ArrayHelper;

$this->title = 'Тесты';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $olimpicModel->name;

echo '<div class="container">';

GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
//        ['attribute' => 'introduction',
//            'format' => 'raw'],
//
//        ['attribute' => 'final_review',
//            'format' => 'raw'],
        [
            'attribute' => 'classesList',
            'value' => function ($model) {
                /** @var \app\modules\test\models\Test $model */
                return \implode(',', ArrayHelper::getColumn($model->classes, 'name'));
            }
        ],
    ],
    'createRoute' => ['create', 'olimpicId' => $olimpicModel->id]
]);

echo '</div>';