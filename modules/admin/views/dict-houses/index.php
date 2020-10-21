<?php

use app\models\DictHouses;
use app\modules\admin\form\SelectFilterInput;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DictAngleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дома';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-angle-index">

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
            'name',
            'flat_count',
            ['attribute'=> 'moderation', 'value'=> 'moderationName', 'filter'=> DictHouses::moderationItem()],
            [
                'attribute' => 'deadline',
                'filter' => SelectFilterInput::dateWidgetRangeSearch($searchModel, 'deadline', 'deadline'),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
