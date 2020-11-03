<?php

use app\modules\admin\form\SelectFilterInput;
use app\modules\admin\models\DictShops;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \app\modules\admin\models\DictGoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            ['attribute' => 'shop_id',
                'header'=> "Магазины",
                'filter' =>  SelectFilterInput::dataSearchModel($searchModel, DictShops::allColumn() , 'shop_id', 'shopName'),
                'value' => "shopsName"]
        ],
    ]); ?>
</div>