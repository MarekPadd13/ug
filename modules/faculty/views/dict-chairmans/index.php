<?php

use himiklab\yii2\ajaxedgrid\GridView;

/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Председатели';
$this->params['breadcrumbs'][] = $this->title;

echo '<div class="container">';

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'last_name',
        'first_name',
        'patronymic',
        'position',
    ],
]);

echo '</div>';

