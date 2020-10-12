<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RefAnswerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ref Answers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-answer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ref Answer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'content:ntext',
            'legasy_status',
            'type',
            //'ref_problems_id',
            //'date_start',
            //'date_finish',
            //'author_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
