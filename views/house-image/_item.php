<?php
/* @var $this yii\web\View */

/* @var $model app\models\DictHouses */

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['view', 'id' => $model->id]);

?>
<div class="col-md-3" style="border: 1px solid #0A8ED0">
    <h4>Дом: <?= Html::encode($model->name) ?></h4>
    <p>Количество фотографий: <?= $model->getImages()->count() ?></p>
    <p>Дата последнего снимка: <?= $model->lastImage->date ?></p>
    <p><a class="btn btn-primary" href="<?= Html::encode($url) ?>" role="button">Подробнее</a></p>
</div>

