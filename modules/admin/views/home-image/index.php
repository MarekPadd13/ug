<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\form\SelectFilterInput;
use app\models\DictAngle;
use app\models\DictHouses;
use app\models\HomeImage;
/* @var $this yii\web\View */
/* @var $searchModel app\models\HomeImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фото домов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-answer-index">

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
                'attribute' => 'angle_id',
                'filter' =>  SelectFilterInput::dataSearchModel($searchModel,DictAngle::allColumn() , 'angle_id', 'angle.name'),
                'value' => 'angle.name'
            ],
            [
                'attribute' => 'home_id',
                'filter' =>  SelectFilterInput::dataSearchModel($searchModel,DictHouses::allColumn() , 'home_id', 'home.name'),
                'value' => 'home.name'
            ],
            'link',
            [
                'attribute' => 'status',
                'filter' => HomeImage::statusList(),
                'value' => 'statusName'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
