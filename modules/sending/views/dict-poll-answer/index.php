<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\sending\models\DictPollAnswersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ответы опросов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-poll-answers-index">

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

            'name',

            ['class' => 'yii\grid\ActionColumn', 'template'=> '{update} {delete}'],
        ],
    ]); ?>
</div>
