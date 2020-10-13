<?php

use yeesoft\lightbox\Lightbox;

/* @var $this yii\web\View */
/* @var $model app\models\DictHouses */
/* @var $image app\models\HomeImage */

$itemsLight = [];
foreach ($model->getAnglesImages($angle_id) as $index => $image) {
    $itemsLight[$index]['thumb'] = $image->getThumbFileUrl('image', 'preview');
    $itemsLight[$index]['image'] = $image->getImageFileUrl('image');
    $itemsLight[$index]['group'] = 'image-set'.$image->angle_id;
    $itemsLight[$index]['title'] = '<h2> Ракурс: ' . $image->angle->name . '</h2> <p class="pull-right">Дата: ' . $image->date . '</p> <p>Источник: ' . $image->link . '</p>';
}
?>
<?= Lightbox::widget([
    'options' => [
        'fadeDuration' => '2000',
        'albumLabel' => "Image %1 of %2",
    ],
    'linkOptions' => ['class' => 'pull-left'],
    'imageOptions' => ['class' => 'thumbnail'],
    'items' => $itemsLight
]); ?>