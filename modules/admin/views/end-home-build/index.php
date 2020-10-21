<?php

use app\models\DictHouses;
use app\modules\admin\form\SelectFilterInput;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EndHomeBuildSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Степень завершения строительства';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="end-home-build-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'home_id',
                'filter' =>  SelectFilterInput::dataSearchModel($searchModel,DictHouses::allColumn() , 'home_id', 'home.name'),
                'value' => 'home.name'
            ],
            'number',

            [
                'attribute' => 'date',
                'filter' => SelectFilterInput::dateWidgetRangeSearch($searchModel, 'date', 'date'),
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{delete} {update}'],
        ],
    ]); ?>
</div>
