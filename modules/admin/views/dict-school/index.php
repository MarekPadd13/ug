<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DictSchoolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Учебные организации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dict-school-index">

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
            'dictCity.name',
            ['attribute'=>'moderation',
                'value'=>function($model){
                   return $model->GetModerationItem()[$model->moderation];
                }],

       ['class' => 'yii\grid\ActionColumn', 'template'=>'{update}{delete}'],
        ],
    ]); ?>
</div>
