<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DictCategoryDocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;

$typeCategory = \app\models\DictCategoryDoc::typeOfCategory();

?>
<div class="dict-category-doc-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'type_id',
                'format' => 'raw',
                'value' => function ($model) use ($typeCategory) {
                    return $typeCategory[$model->type_id];
                },
                'filter'=> $typeCategory,
            ],

            ['class' => 'yii\grid\ActionColumn', 'template'=> '{update} {delete}'],
        ],
    ]); ?>
</div>
