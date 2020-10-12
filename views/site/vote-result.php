<?php

use yii\helpers\Html;

$this->title = 'Результаты голосования в режиме реального времени';
$this->params['breadcrumbs'][] = $this->title;

echo '<h1>'.$this->title.'</h1>';

echo Html::decode($result);