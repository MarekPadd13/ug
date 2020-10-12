<?php

/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $this yii\web\View */

use himiklab\yii2\ajaxedgrid\GridView;

$this->title = 'Группы вопросов';
$this->params['breadcrumbs'][] = $this->title;

echo '<div class="container">';

GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'olimpic.name',
            'label' => 'Олимпиада',
        ],
        'name',
    ],
]);

echo '</div>';
