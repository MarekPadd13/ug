<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StreamSearch */
/* @var $data yii\data\ActiveDataProvider */

$this->title = 'Ход строительства';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stream-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Загрузить фото', ['add-photo'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=\yii\widgets\ListView::widget([
        'dataProvider' => $data,
        'layout' => "{items}\n{pager}",
        'beforeItem' => function($model , $key , $index , $widget) {
            return  $index%3 == 0 ? '<div class="row" style="margin-bottom: 15px">':"";
        },
        'afterItem' => function($model , $key , $index , $widget) use($data) {
            return  $index%3 == 2  || ($data->getTotalCount() - 1) == $index ? '</div>': "";
        },
        'itemView' => '_item',
    ]) ?>


</div>
