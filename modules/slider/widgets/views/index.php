<?php

use yii\helpers\Html;


$items = [];

foreach($images as $image) {
     $items[] = Html::img($image->getUrl('medium'));
}

echo \yii\bootstrap\Carousel::widget([
    'items' => $items,
    'options' => [
        'class' => 'carousel slide carousel-fade',
    ],
    'controls' => [
        '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>',
        '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'
    ]
]);
?>
