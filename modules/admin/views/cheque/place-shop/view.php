<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ShopPlaces */

$this->title = $model->shop->name. " ". $model->dateView;
?>
    <h4><?= Html::encode($this->title) ?></h4>

<?= GridView::widget([
    'dataProvider' => new ActiveDataProvider(['query' => $model->getBuyGoods()]),
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'good.name', 'price', 'quantity', 'sum', 'nds10', 'nds20'
    ],
]); ?>

    <?= DetailView::widget([
    'options' => ['class' => 'table', 'style'=>['width'=> '100%']],
        'model' => $model,
        'attributes' => [
            'totalSum',
            'nds10',
            'nds20',
            'count'
        ],
    ]) ?>
