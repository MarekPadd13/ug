<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StreamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фотографии домов';
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
            return  $index%4 == 0 ? '<div class="row">':"";
        },
        'afterItem' => function($model , $key , $index , $widget) {
            return  $index%4 == 3 ? '</div>': "";
        } ,
        'itemView' => '_item',
    ]) ?>


</div>