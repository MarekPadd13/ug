<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VoteQuestionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vote Questions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vote-questions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vote Questions', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'text:ntext',
            'type',
            'extension',
            //'moderation',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
