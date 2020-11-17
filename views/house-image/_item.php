<?php
/* @var $this yii\web\View */

/* @var $model app\models\DictHouses */

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['view', 'id' => $model->id]);

?>
<div class="col-sm-6 col-md-4" >
    <div class="thumbnail" style="border:  <?= $model->getLastPublishedDate($model->lastImage->date) ? "2px solid green" : "1px solid #0A8ED0"?>">
        <div class="caption">
            <h4>Дом: <?= Html::encode($model->name) ?></h4>
            <p>Количество фотографий: <?= $model->getImages()->count() ?></p>
            <p>Дата последнего снимка: <?= $model->lastImage->dateView ?></p>
            <p>Степень готовности: <?= $model->maxNumber ? $model->maxNumber.'%' : 'нет данных' ?></p>
            <p>Темп строительства: <?= $model->lastPace ?></p>
            <p><a class="btn btn-primary" href="<?= Html::encode($url) ?>" role="button">Подробнее</a></p>
        </div>
    </div>
</div>