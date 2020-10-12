<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RefProblemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ref Problems';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-problems-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ref Problems', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'description',
            'full_text:ntext',
            'user_id',
            //'moderation',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
