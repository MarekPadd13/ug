<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DictCountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dict Countries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-country-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dict Country', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'cis',
            'far_abroad',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
