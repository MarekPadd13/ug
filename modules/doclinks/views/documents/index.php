<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\DictCategoryDoc;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Документы';
$this->params['breadcrumbs'][] = $this->title;

$categories = ArrayHelper::map(DictCategoryDoc::find()->andWhere(['type_id'=>DictCategoryDoc::TYPEDOC])->all(), 'id', 'name');
?>
<div class="documents-index">

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

            'name:ntext',
            [
                'attribute' => 'category_id',
                'value' => function ($model) use ($categories) {
                    return $categories[$model->category_id];
                },
                'filter'=> $categories,
            ],

            ['class' => 'yii\grid\ActionColumn', 'template'=> '{delete}'],
        ],
    ]); ?>
</div>
