<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RefDoljnostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ref Doljnosts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-doljnost-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ref Doljnost', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'ball',
            'ref_answer_id',
            'moderation',
            //'description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
