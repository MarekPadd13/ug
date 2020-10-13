<?php

use yeesoft\lightbox\Lightbox;
use yii\bootstrap\Carousel;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DictHouses */
/* @var $image app\models\HomeImage */

$this->title = "Фотографии дома  ". $model->name;
$this->params['breadcrumbs'][] = ['label' =>"Фотографии домов", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$items = [];
$itemsLight= []
?>
<div class="stream-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Загрузить фото ', ['add-photo-home', 'home_id'=>$model->id], ['class' => 'btn btn-success']) ?>
    </p>
        <?php foreach ($model->images as $index => $image) {
            $items[$index]['content'] =  Html::img($image->getImageFileUrl('image'));
            $itemsLight[$index]['thumb'] = $image->getImageFileUrl('image');
            $itemsLight[$index]['image'] = $image->getImageFileUrl('image');
            $itemsLight[$index]['title'] =  '<h2> Ракурс: '. $image->angle->name .'</h2> <p class="pull-right">Дата: '. $image->date  .'</p> <p>Источник: '. $image->link     .'</p>';
            $items[$index]['caption'] =  '<h2> Ракурс: '. $image->angle->name .'</h2> <p class="pull-right">Дата: '. $image->date  .'</p> <p>Источник: '. $image->link     .'</p>';

        }
    ?>

    <?= Lightbox::widget([
    'options' => [
    'fadeDuration' => '2000',
    'albumLabel' => "Image %1 of %2",
    ],
    'linkOptions' => ['class' => 'pull-left'],
    'imageOptions' => ['class' => 'thumbnail','height'=>100, 'width'=>100 ],
    'items' => $itemsLight
    ]); ?>
</div>
