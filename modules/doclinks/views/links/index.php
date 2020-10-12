<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\DictCategoryDoc;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LinksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ссылки';
$this->params['breadcrumbs'][] = $this->title;

$categories = ArrayHelper::map(DictCategoryDoc::find()->andWhere(['type_id'=>DictCategoryDoc::TYPELINK])->all(), 'id', 'name');

?>
<div class="links-index">

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


            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->name, $model->href);
                }
            ],

            [
                'attribute' => 'category_id',
                'value' => function ($model) use ($categories) {
                    return $categories[$model->category_id];
                },
                'filter'=> $categories,
            ],



            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ]]); ?>
</div>