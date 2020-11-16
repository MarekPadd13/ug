<?php

use yeesoft\lightbox\Lightbox;

/* @var $this yii\web\View */
/* @var $model app\models\DictHouses */
/* @var $image app\models\HomeImage */
?>
<style>
    #lightbox {
        display: flex;
        flex-direction: column-reverse;
    }
</style>
<?php
$itemsLight = [];
foreach ($model->getAnglesImages($angle_id) as $index => $image) {
    $itemsLight[$index]['thumb'] = $image->getThumbFileUrl('image', 'preview');
    $itemsLight[$index]['image'] = $image->getImageFileUrl('image');
    $itemsLight[$index]['group'] = 'image-set'.$image->angle_id;
    $itemsLight[$index]['title'] = '<h4>'. ($image->date_visible ? 'Ракурс: ': '') .
        $image->angle->name . ($image->date_visible ? '<span class="pull-right">Дата: ' . $image->dateView . '</span>': '').'</h4> 
<p>Источник: ' . $image->link . '</p>'. ($image->published ? '<p>'.$image->description.'</p>': '');
}
?>
<?= Lightbox::widget([
    'options' => [
        'fadeDuration' => '2000',
        'albumLabel' => "Фото %1 из %2",
    ],
    'linkOptions' => ['class' => 'pull-left'],
    'imageOptions' => ['class' => 'thumbnail'],
    'items' => $itemsLight
]); ?>