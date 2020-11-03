<?php

use app\modules\admin\form\SelectFilterInput;
use app\modules\admin\models\DictShops;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \app\modules\admin\models\ShopPlacesSearch*/
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Чеки';
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
            ['attribute' => 'shop_id',
                'filter' =>  SelectFilterInput::dataSearchModel($searchModel, DictShops::allColumn() , 'shop_id', 'shopName'),
                'value' => "shop.name"],
            'totalSum', 'nds10', 'nds20',
            ['attribute' => 'date',
                'filter' => SelectFilterInput::dateWidgetRangeSearch($searchModel, 'date_from', 'date_to', \kartik\date\DatePicker::TYPE_RANGE),
                'value' => 'dateView'],

            ['attribute' => 'count',
                'format'=> 'raw',
                'value' => function($model) {
                   return Html::a($model->count, ['view', 'id'=> $model->id], ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => "Чек"]);
                }],
        ],
    ]); ?>
</div>
<?php
$this->registerJs(<<<JS
$("[data-target=\"#modal\"]").click(function(e) {
    e.preventDefault();
    var url = $(this).attr("href");
    var modalTitle = $(this).attr("data-modalTitle");
    var modal = $('#modal');
        modal.find('#header-h4').text(modalTitle);
        modal.find('#modalContent').load(url);
});
JS
);
?>

<?php Modal::begin([ 'id'=>'modal', 'size'=> Modal::SIZE_LARGE, 'header' => "<h4 id='header-h4'></h4>", 'clientOptions' => ['backdrop' => false]]) ?>
<div id='modalContent'></div>
<?php Modal::end() ?>
