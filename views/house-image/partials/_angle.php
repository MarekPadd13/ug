<?php

use yeesoft\lightbox\Lightbox;

/* @var $this yii\web\View */
/* @var $model app\models\DictHouses */
/* @var $image app\models\HomeImage */

$itemsLight = [];
foreach ($model->getAnglesImages($angle_id) as $index => $image) {
    $itemsLight[$index]['thumb'] = $image->getImageFileUrl('image');
    $itemsLight[$index]['image'] = $image->getImageFileUrl('image');
    $itemsLight[$index]['title'] = '<h2> Ракурс: ' . $image->angle->name . '</h2> <p class="pull-right">Дата: ' . $image->date . '</p> <p>Источник: ' . $image->link . '</p>';
}
?>
<?= Lightbox::widget([
    'options' => [
        'fadeDuration' => '2000',
        'albumLabel' => "Image %1 of %2",
    ],
    'linkOptions' => ['class' => 'pull-left'],
    'imageOptions' => ['class' => 'thumbnail', 'height' => 100, 'width' => 100],
    'items' => $itemsLight
]); ?>